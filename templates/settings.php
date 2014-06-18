<div class="wrap">
    <h1>Adobe Analytics for WordPress</h1>
    <ul class="nav-tab-wrapper" id="adobe-analytics-tabs-controller">
      <li class="nav-tab"><a id="info-tab" class="active" href="#top#info"><?php _e('Info', 'adobe-analytics');?></a></li>
      <li class="nav-tab"><a id="info-tab" href="#top#instructions"><?php _e('Instructions', 'adobe-analytics');?></a></li>
      <li class="nav-tab"><a id="settings-tab" href="#top#settings"><?php _e('Settings', 'adobe-analytics');?></a></li>
      <li class="nav-tab"><a id="credits-tab" href="#top#credits"><?php _e('Credits', 'adobe-analytics');?></a></li>
    </ul>
    <div id="adobe-analytics-tabs-content">

      <!-- Info Tab -->
      <section id="info" class="active">
        <h2>Info</h2>
        <p>Adobe Analytics for WordPress is a solution developed by RepEquity to make it easier to enable custom pageCode for Adobe Analytics (formerly Omniture SiteCatalyst).  There have been a few older plugins that offer tracking suitable for blogs.  These however have not been well maintained and do not easily support custom variables and other settings for websites other than plugins.</p>
        <p>This plugin is meant to provide those who are trained and familiar with Adobe Analytics implementation with a highly customizable tool for pageCode management.</p><br/>
        Future Plans
        <ul>
          <li>• Method to set pageName value other than first entry or page level override as is current method</li>
          <li>• Automated placement of s.pageType = “errorPage”; on 404 error pages</li>
          <li>• Implementation of internals search variables</li>
          <li>• Replacement token WPML integration to set a variable for selected language</li>
          <li>• Support for s.event execution on comment submission</li>
          <li>• Finish integration of per-post and per-page custom variables</li>
          <li>• Make the custom variables form on the post/page form and the plugin settings form match</li>
          <li>• Strip out parts of the metaboxes library that are not needed (i.e.. all of it except for the repeating field part)</li>
          <li>• Add more tokens</li>
          <li>• Clean up code that generates the analytics script into its own class with separate methods for each part of the script</li>
          <li>• Add script preview to settings page</li>
          <li>• Allow reordering the script</li>
          <li>• Make translatable with WPML support</li>
          <li>• Make multisite compatible</li>
        </ul>
        </p>
        <h2 class="sponsorship">Proudly Sponsored by: <a href="http://repequity.com" target="_blank"><img src="<?php echo plugins_url('templates/assets/re-horizontal.png', dirname(__FILE__)); ?>" alt="RepEquity"/></a></h2>
      </section> <!-- end of info page -->

      <!-- Instructions Tab -->
      <section id="instructions">
        <h2>Instructions</h2>
        <p>Library URL – Place in a relative or absolute URL path to the s_code or AppMeasurement.js file.</p>
        <p>For example: /wp-content/plugins/adobe_analytics/library/AppMeasurement.js</p>
        <p>Be sure to remove the s_account variables and all other settings from the JavaScript file.  The s_account and all other settings and configurations will be put into place by the plugin for both the script and the img src beacon. This allows for a single JavaScript file to be used for multiple installations.</p>
        <p>Account ID – Enter the Report Suite ID that you would use for the s_account variable.  You may use comma separated values for multi Suite reporting.</p>
        <p>Custom JS – Place in all of the configurations as well as plugins that you would normally place in the JavaScript file. <a href="https://gist.github.com/smiro2000/7831556" target="_blank">Here is an example of this code.</a></p>
        <p>All Global Variables – This section is for the placement of variables and values to appear on every page/post. Enter the variable name in the first column.  Enter the value in the second column.  You may add as many combinations as desired.</p>
        <p>For example; you could place s.channel  in the first column and then blog in the second column. Every page/post would then have this pair in the pageCode.</p>
        <p>There are a number of replacement tokens that may be used in the value field.  Replacement tokens may be used in combination with text or other replacement tokens.  <a href="mailto:info@repequity.com">Send us a note</a> if you have an idea for other replacement tokens.</p>
        <p>You currently have the folowing tokens available:</p>
        <ul>
          <li>• categories : Returns a list of comma separated categories associated with the current page.</li>
          <li>• category :Returns the first category associated with the current page.</li>
          <li>• type : Returns the page type (ie. home, page, post, category, tag, month).</li>
          <li>• breadcrumbs : breadcrumbs for the current page as defined by the page hierarchy</li>
          <li>• wpseo_breadcrumbs : breadcrumbs for the current page as defined by the wordpress seo plugin. The plugin must be installed and enabled. You must also replace the file frontend/class-breadcrumbs.php with a modified version found here => http://ow.ly/sfinZ or (advanced) applying a git diff patch found here => http://ow.ly/sfive</li>
        </ul>
        <h3>Individual Post and Page Variables</h3>
        <p>Each post and page includes an Adobe Analytics Variables section.  You can place a variable name and value to place custom values for the individual post or page. This will override any of the conflicting values you may have entered as global variables.</p>
      </section><!-- end of instructions page -->

      <!-- Settings Tab -->
      <section id="settings">
        <h2>Settings</h2>
        <p>These settings determine the basic reporting to the Adobe Analytics (formerly Omniture SiteCatalyst).</p><br/>
        <form method="post" action="options.php">
          <?php settings_fields('adobe_analytics-group'); ?>

          <div class="form-field libray_url"><label for="adobe_analytics_library_url">Library URL</label>
          <input type="text" name="adobe_analytics_library_url" id="adobe_analytics_library_url" value="<?php echo get_option('adobe_analytics_library_url'); ?>" size="50">
          <p>Can be external url or absolute path to AppMeasurement.js or s_code.js library.<br>Should be UNALTERED version of the library. Alterations can be added in the "Custom JS" field.</p></div>

          <div class="form-field account_id"><label for="adobe_analytics_account_id">Account ID</label>
          <input type="text" name="adobe_analytics_account_id" id="adobe_analytics_account_id" value="<?php echo get_option('adobe_analytics_account_id'); ?>" size="50">
          <p>The reporting suite where the data is saved to.</p></div>

          <div class="form-field custom_js"><label for="adobe_analytics_custom_js">Custom JS</label>
          <textarea name="adobe_analytics_custom_js" id="adobe_analytics_custom_js" rows="5" cols="50"><?php echo htmlspecialchars(get_option('adobe_analytics_custom_js')); ?></textarea>
          <p>Add custom javascript block here (ie. plugin code). Do not include script tags.<br>WARNING: Risk of XSS - Use at your own risk!</p></div>

          <div class="form-field custom_variables"><label for="adobe_analytics_custom_variables">Custom Variables</label>
          <input type="text" name="adobe_analytics_custom_variables" id="adobe_analytics_custom_variables" value="<?php echo htmlspecialchars(get_option('adobe_analytics_custom_variables')); ?>" size="50">
          <p>Serialized array of custom global variables. Only visible during testing.</p></div>

          <legend>All Global Variables</legend>
          <fieldset name="variables" class="repeatable-wrap">
            <ul id="tracks-repeatable" class="repeatable-fields-list">
              <li>
                <input type="text" name="key_1" value=""/>
                <input type="text" name="val_1" value=""/>
                <a class="repeatable-field-remove button" href="#">REMOVE</a>
              </li>
            </ul>
          <a class="repeatable-field-ali button" href="#">ADD</a>
          </fieldset>
          <br/>
          <div>
            Custom variables now support the following replacement tokens:
            <ul>
              <li>categories : a list of comma separated categories associated with the current page</li>
              <li>category : the first category associated with the current page</li>
              <li>type : returns the page type (ie. home, page, post, category, tag, month)</li>
              <li>breadcrumbs : breadcrumbs for the current page as defined by the page hierarchy</li>
              <li>wpseo_breadcrumbs : breadcrumbs for the current page as defined by the wordpress seo plugin (plugin must be installed, enabled, and modified according to instructions in the "Instructions" tab.</li>
            </ul>
          </div>
          <?php submit_button(); ?>
        </form>
      </section> <!-- end of #settings page -->

      <!-- Credits Tab -->
      <section id="credits">
        <h2>Credits</h2>
        <p>The Adobe Analytics for WordPress plugin was created by  the development team at <a href="http://www.repequity.com" target="_blank">RepEquity</a>.  It is maintained and routinely updated by RepEquity based upon client requirements.  Please submit any notes, observations or requests to <a href="mailto:info@repequity.com">RepEquity</a>.</p>
        <p>Special thanks to:<br/>
          Miro Scarfiotti (smiro2000) – Lead plugin developer<br/>
          Daniel Katz (diverdan) – Adobe Analytics specialist
        </p>
        <h2 class="sponsorship">Proudly Sponsored by: <a href="http://repequity.com" target="_blank"><img src="<?php echo plugins_url('templates/assets/re-horizontal.png', dirname(__FILE__)); ?>" alt="RepEquity"/></a></h2>
      </section> <!-- end of credits page -->

    </div> <!-- closes #adobe-analytics-tabs-content -->

</div>

