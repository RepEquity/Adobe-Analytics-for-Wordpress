<?php
/**
 * Plugin Name: Adobe Analytics for WordPress
 * Plugin URI: n/a
 * Description: Facilitates integration with the Adobe Analytics library.
 * Version: 0.6.8
 * Author: RepEquity
 * Author URI: http://www.repequity.com
 * License: GPLv3 as defined here => http://opensource.org/licenses/GPL-3.0
 */

if(!class_exists('Adobe_Analytics'))
{
  class Adobe_Analytics
  {
    /**
     * Construct the plugin object
     */
    public function __construct() {

      // Initialize Settings Page
      require_once(sprintf("%s/settings.php", dirname(__FILE__)));
      $adobe_analytics_settings = new Adobe_Analytics_Settings();

      // Initialize Repeatable Meta Field library
      require sprintf("%s/meta_fields.php", dirname(__FILE__));
      $adobe_analytics_meta_fields = new AdobeAnalyticsMetaFields();

      // Initialize Analytics Script
      // useless for now
      // require sprintf("%s/build_script.php", dirname(__FILE__));
      // $build_script = new BuildScript();
    }

    /**
     * Activate the plugin
     */
    public static function activate() {
      // Do nothing
    }

    /**
     * Deactivate the plugin
     */
    public static function deactivate() {
      // TODO: deleted options from database
    }

    /**
     * Build the javascript for the header
     */
    public function init() {
      //AppMeasuements library path
      $library_url = get_option('adobe_analytics_library_url');
      //register analitics library
      wp_register_script('appmeasurements', $library_url, array(), false, true);
      wp_enqueue_script('appmeasurements');

    }

    public function script() {
      //initialize variables
      $vars = array();
      //loading the options
      $vars['app_id'] = get_option('adobe_analytics_account_id');
      $vars['custom_js'] = get_option('adobe_analytics_custom_js');
      $vars['custom_variables'] = get_option('adobe_analytics_custom_variables');
      $vars['page_type'] = self::page_type();

      //on-page configs
      // $vars['url'] = get_permalink();
      $vars['post_title'] = get_the_title();
      $vars['archive_title'] = single_cat_title('', false);
      if (is_home()) {
        $vars['page_title'] = 'Home Page';
      } elseif (is_page()) {
        $vars['page_title'] = the_title('', '', false);
      } elseif (is_single()) {
        $vars['page_title'] = the_title('', '', false);
      } elseif (is_category()) {
        $vars['page_title'] = 'Category: ' . single_cat_title('', false);
      } elseif (is_tag()) {
        $vars['page_title'] = 'Tag: ' . single_tag_title('', false);
      } elseif (is_month()) {
        list($month, $year) = split(' ', the_date('F Y', '', '', false));
        $vars['page_title'] = 'Month Archive: ' . $month . ' ' . $year;
      // } elseif (is_404()) {
      //   $vars['page_title'] = 'errorPage';
      }

      //the tracking script
      ?><script type="text/javascript">
        s = new AppMeasurement(); //initialize library as s
        s.account="<?php echo $vars['app_id']; ?>" //sets metric accounts
        <?php echo $vars['custom_js']; ?> //adds custom js from settings page (ie. plugins etc..)
        s.pageName="<?php echo $vars['page_title']; ?>" //page title variable
        <?php
        /**
         * Handling of custom variables
         */
        if (!is_null($vars['custom_variables']) && !empty($vars['custom_variables'])) {
          $custom_variables = json_decode($vars['custom_variables'], TRUE);
          $i = 0;
          foreach ($custom_variables as $cv) {
            $i++;
            if (!empty($cv['value'])) {
              if ($i & 1) {
                echo 's.'.$cv['value'].'= '; //the custom variable name
              } else {
                //the custom variable value sanitized and checked for replacement tokens
                echo '"'.self::analytics_token(htmlspecialchars($cv['value']))."\";\n";
              }
            }
          }
        }
        //prits out the page custom variables
        $page_vars = self::page_vars(get_the_ID());
        if (!is_null($page_vars)) {
          echo $page_vars;
        }?>
        var s_code=s.t();
        if(s_code)document.write(s_code);//-->
      </script><?php

    }

    /**
     * Checks if the custom variable is a predefined token
     * Returns appropriate value if it is
     * tokens: 'categories', 'category', 'date', 'type'
     */
    public function analytics_token($token) {
      switch ($token) {
        case 'categories': //returns a comma separated list of categories
          foreach (get_the_category() as $category) {
            if (is_null($categories)) {
              $categories = $category->name;
            } else {
              $categories .= ', '.$category->name;
            }
          }
          return $categories;
          break;

        case 'category': //returns the first category associated with the current page
          $categories = get_the_category();
          return $categories[0]->cat_name;
          break;

        case 'date': //returns the date associated with the current page
          $categories = get_the_category();
          return $categories[0]->cat_name;
          break;

        case 'type': //returns the first category associated with this item
          return self::page_type();
          break;

        case 'breadcrumbs': //return comma separated list of ancestors which should match to the breadcrumb
          //provides support for wordpress_seo by yoast breadcrumbs
          $ancestors = get_post_ancestors(get_the_ID());
          foreach ($ancestors as $ancestor) {
            if (is_null($breadcrumbs)) {
              $breadcrumbs = get_the_title($ancestor);
            } else {
              $breadcrumbs .= ', '.get_the_title($ancestor);
            }
          }

          return $breadcrumbs;
          break;

        case 'wpseo_breadcrumbs': //provides support for wordpress_seo by yoast breadcrumbs
          if (function_exists('yoast_breadcrumb')) {
            global $wpseo_bc;
            $bc_array = $wpseo_bc->breadcrumb('', '', 'array');
            foreach ($bc_array as $bc) {
              if (is_null($breadcrumbs)) {
                $breadcrumbs = $bc['text'];
              } else {
                $breadcrumbs .= ', '.$bc['text'];
              }
            }
          } else {
            return 'wordpress_seo plugin needs to be installed and enabled first.';
          }

          return $breadcrumbs;
          break;

        case 'wpml_lang': //returns the current language if wmpl is enabled
          if (function_exists('wpml_get_language_information')) {
            $language = wpml_get_language_information();
            $language = explode('_', $language['locale']);
            return $language[0];
          }
          break;

        default:
          return $token;
          break;
      }
    }


    /**
     * Returns the page type we are on
     * options are: home, page, post, category, tag, month
     * TODO: use this correctly
     */
    public function page_type() {
      if (is_home()) {
        return 'home';
      } elseif (is_page()) {
        return 'page';
      } elseif (is_single()) {
        return 'post';
      } elseif (is_category()) {
        return 'category';
      } elseif (is_tag()) {
        return 'tag';
      } elseif (is_month()) {
        return 'month';
      } elseif (is_404()) {
        return 'errorPage';
      }
    }

    /**
     * Gets Adobe Analytics metadata for the page
     * @param  int $id the post or page id
     * @return array     key->value pair of page variables name and values
     */
    public function page_vars($id) {
      //only supported for pages and posts
      $type = self::page_type();
      if (($type == 'post') || ($type == 'page')) {
        $vars = get_post_meta($id, 'adobe_analytics_repeatable');

        if (!empty($vars[0])) {
          foreach ($vars[0] as $var) {
            if (!empty($var['name']) && !empty($var['value'])) {
              $page_vars .= 's.'.$var['name'].'= "'.self::analytics_token(htmlspecialchars($var['value']))."\";\n";
            }
          }
        }
        return $page_vars;
      }
    }


  } // END class Adobe_Analytics
} // END if(!class_exists('Adobe_Analytics'))


/**
 * Runs hooks and actions to enable plugin functionality
 */
if(class_exists('Adobe_Analytics')) {
  // Installation and uninstallation hooks
  register_activation_hook(__FILE__, array('Adobe_Analytics', 'activate'));
  register_deactivation_hook(__FILE__, array('Adobe_Analytics', 'deactivate'));

  // instantiate the plugin class
  $adobe_analytics = new Adobe_Analytics();

  if(isset($adobe_analytics)) {
    // Add the settings link to the plugins page
    function plugin_settings_link($links) {
      $settings_link = '<a href="options-general.php?page=adobe_analytics">Settings</a>';
      array_unshift($links, $settings_link);
      return $links;
    }
    $plugin = plugin_basename(__FILE__);
    add_filter("plugin_action_links_$plugin", 'plugin_settings_link');

    //adds our header javascript on non-admin pages
    if (!is_admin()) {
      add_action('init', array('Adobe_Analytics', 'init'));
      add_action( 'wp_print_footer_scripts', array('Adobe_Analytics', 'script'), 50 );
    }
  }
}

