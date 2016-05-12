<?php
add_action( 'cmb2_init', 'cmb2_sample_metaboxes' );

/**
 * Define the metabox and field configurations.
 */
function cmb2_sample_metaboxes() {

  // Start with an underscore to hide fields from custom fields list
  $prefix = '_yourprefix_';

  /**
   * Initiate the metabox
   */
  $cmb = new_cmb2_box( array(
      'id'            => 'test_metabox',
      'title'         => esc_html__( 'Test Metabox', 'cmb2' ),
      'object_types'  => array( 'page', ), // Post type
      'context'       => 'normal',
      'priority'      => 'high',
      'show_names'    => true, // Show field names on the left
      // 'cmb_styles' => false, // false to disable the CMB stylesheet
      // 'closed'     => true, // Keep the metabox closed by default
  ) );

  // Regular text field
  $cmb->add_field( array(
      'name'       => esc_html__( 'Test Text', 'cmb2' ),
      'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
      'id'         => $prefix . 'text',
      'type'       => 'text',
      'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
      // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
      // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
      // 'on_front'        => false, // Optionally designate a field to wp-admin only
      // 'repeatable'      => true,
  ) );

  // URL text field
  $cmb->add_field( array(
      'name' => esc_html__( 'Website URL', 'cmb2' ),
      'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
      'id'   => $prefix . 'url',
      'type' => 'text_url',
      // 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
      // 'repeatable' => true,
  ) );

  // Email text field
  $cmb->add_field( array(
      'name' => esc_html__( 'Test Text Email', 'cmb2' ),
      'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
      'id'   => $prefix . 'email',
      'type' => 'text_email',
      // 'repeatable' => true,
  ) );

  // Add other metaboxes as needed
}