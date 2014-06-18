<?php
if(!class_exists('Adobe_Analytics_Settings')) {
  class Adobe_Analytics_Settings {
    /**
     * Construct the plugin object
     */
    public function __construct() {
      // register actions
      add_action('admin_init', array(&$this, 'admin_init'));
      add_action('admin_menu', array(&$this, 'add_menu'));
    } // END public function __construct

    /**
     * hook into WP's admin_init action hook
     */
    public function admin_init() {
      // register your plugin's settings
      register_setting('adobe_analytics-group', 'adobe_analytics_library_url'); //path to external library
      register_setting('adobe_analytics-group', 'adobe_analytics_account_id'); //
      register_setting('adobe_analytics-group', 'adobe_analytics_custom_js'); //custom js to add to the page
      register_setting('adobe_analytics-group', 'adobe_analytics_custom_variables'); //custom js to add to the page

      // add your settings section
      add_settings_section(
        'adobe_analytics-section',
        'WP Adobe Analytics Settings',
        array(&$this, 'settings_section_adobe_analytics'),
        'adobe_analytics'
        );

      // add your setting's fields
      add_settings_field(
        'adobe_analytics-library_url',
        'Library URL',
        array(&$this, 'settings_field_input_text'),
        'adobe_analytics',
        'adobe_analytics-section',
        array(
          'field' => 'adobe_analytics_library_url',
          'type' => 'text',
          'description' => 'Can be external url or absolute path to local library.<br/>Should be UNALTERED version of the library. Alterations can be added in the "Custom JS" field.',
        )
      );
      add_settings_field(
        'adobe_analytics-account_id',
        'Account ID',
        array(&$this, 'settings_field_input_text'),
        'adobe_analytics',
        'adobe_analytics-section',
        array(
          'field' => 'adobe_analytics_account_id',
          'type' => 'text',
          'description' => 'The reporting suite where the data is saved to.'
          )
        );
      add_settings_field(
        'adobe_analytics-custom_js',
        'Custom JS',
        array(&$this, 'settings_field_input_text'),
        'adobe_analytics',
        'adobe_analytics-section',
        array(
          'field' => 'adobe_analytics_custom_js',
          'type' => 'textarea',
          'description' => 'Add custom javascript block here (ie. plugin code). Do not include script tags.<br/>WARNING: Risk of XSS - Use at your own risk!'
          )
        );
      add_settings_field(
        'adobe_analytics-custom_variables',
        'Custom Variables',
        array(&$this, 'settings_field_input_text'),
        'adobe_analytics',
        'adobe_analytics-section',
        array(
          'field' => 'adobe_analytics_custom_variables',
          'type' => 'text',
          'description' => 'Serialized array of custom global variables. Only visible during testing.'
          )
        );
    }

    public function settings_section_adobe_analytics() {
        // Think of this as help text for the section.
      echo 'These settings determine the basic reporting to the Abobe Catalyst Analytics.';
    }

    /**
     * This function provides text inputs for settings fields
     */
    public function settings_field_input_text($args) {
      // Get the field name from the $args array
      $field = $args['field'];
      $type = $args['type'];
      $description = $args['description'];
        // Get the value of this setting
      $value = get_option($field);

      switch ($type) {
        case 'text':
        echo sprintf('<input type="text" name="%s" id="%s" value="%s" size="50"/><p>%s</p>', $field, $field, htmlspecialchars($value), $description);
        break;
        case 'textarea':
        echo sprintf('<textarea name="%s" id="%s" rows="5" cols="50"/>%s</textarea><p>%s</p>', $field, $field, htmlspecialchars($value), $description);
        break;
      }
    } // END public function settings_field_input_text($args)

    /**
     * add a menu
     */
    public function add_menu() {
      // Add a page to manage this plugin's settings
      add_options_page(
        'Adobe Analytics Settings',
        'Adobe Analytics',
        'manage_options',
        'adobe_analytics',
        array(&$this, 'plugin_settings_page')
        );
    } // END public function add_menu()

    /**
     * Menu Callback
     */
    public function plugin_settings_page() {
      if(!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
      }
      // Load the settings css and js files
      wp_enqueue_script( 'adobe-analytics-settings-script', plugins_url( 'adobe_analytics/templates/assets/admin-scripts.js', dirname( __FILE__ ) ), array( 'jquery' ), false, true );
      wp_enqueue_style( 'adobe-analytics-settings-style', plugins_url( 'adobe_analytics/templates/assets/admin-styles.css', dirname( __FILE__ ) ), false, false, false );

      // Render the settings template
      include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
    }





  }
}
