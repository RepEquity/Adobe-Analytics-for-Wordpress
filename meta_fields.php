<?php

/**
* TODO: make this better!
*/
class AdobeAnalyticsMetaFields {

  function __construct() {
    // Initialize the MetaBox
    require sprintf("%s/metaboxes/meta_box.php", dirname(__FILE__));

    $prefix = 'adobe_analytics_';

    $fields = array(
      array( // Repeatable & Sortable Text inputs
        'label' => 'Custom Variables',
        'desc'  => 'Define tracking variables specific to this page.', // description
        'id'    => $prefix.'repeatable', // field id and name
        'type'  => 'repeatable', // type of field
        'sanitizer' => array( // array of sanitizers with matching kets to next array
          'featured' => 'meta_box_santitize_boolean',
          'title' => 'sanitize_text_field',
          'desc' => 'wp_kses_data'
        ),
        'repeatable_fields' => array ( // array of fields to be repeated
          'title' => array(
            'label' => 'Name',
            'id' => 'name',
            'type' => 'text'
          ),
          'featuring' => array(
            'label' => 'Value',
            'id' => 'value',
            'type' => 'text'
          ),
        )
      )
    );

    $post_variables = new custom_add_meta_box( 'adobe_analytics', 'Adobe Analytics Variables', $fields, 'post', true );
    $page_variables = new custom_add_meta_box( 'adobe_analytics', 'Adobe Analytics Variables', $fields, 'page', true );
    $page_variables = new custom_add_meta_box( 'adobe_analytics', 'Adobe Analytics Variables', $fields, 'slider', true );
    $page_variables = new custom_add_meta_box( 'adobe_analytics', 'Adobe Analytics Variables', $fields, 'home_highlights', true );

  }
}
