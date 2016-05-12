<?php

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function caviar_add_meta_box() {

	$screens = array('page' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'caviar_sectionid',
			esc_html__( 'Caviar Metabox Field Example', 'caviar_textdomain' ),
			'caviar_meta_box_callback',
			$screen
		);

		add_meta_box(
			'caviar_2',
			esc_html__( 'Caviar Metabox 2', 'caviar_textdomain' ),
			'caviar_meta_box2_callback',
			$screen
		);
	}
}

add_action( 'add_meta_boxes', 'caviar_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function caviar_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'caviar_save_meta_box_data', 'caviar_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$txtName      = get_post_meta( $post->ID, '_txtName', true );
	$txtAddress   = get_post_meta( $post->ID, '_txtAddress', true );
	$txtWebsite   = get_post_meta( $post->ID, '_txtWebsite', true );
	$chkFood      = get_post_meta( $post->ID, '_chkFood', true );
	$selHobby	  = get_post_meta( $post->ID, '_selHobby', true );
	$selTrans	  = get_post_meta( $post->ID, '_selTrans', true );
	$itemFeatures = get_post_meta( $post->ID, '_itemFeatures', true );
	$gender       = get_post_meta( $post->ID, '_gender', true );
	$colorMeta    = get_post_meta( $post->ID, '_colorMeta', true );
	$edAboutMe    = get_post_meta( $post->ID, '_edAboutMe', true );
	$selCats      = get_post_meta( $post->ID, '_selCats', true );
	$upPhoto      = get_post_meta( $post->ID, '_upPhoto', true );
	$upLicense    = get_post_meta( $post->ID, '_upLicense', true );
	$rePersonalData    = get_post_meta( $post->ID, '_rePersonalData', true );

	// var_dump($rePersonalData);

	$fields  = array(
		'title' => array(
			'title' => 'Feature',
			'type'  => 'text',
		),
		'desc' => array(
			'title' => 'Price',
			'type'  => 'textarea',
		),
		'pic' => array(
			'id' => 'repeaterPic',
			'title' => 'Picture',
			'type'  => 'upload',
		),
		'featured' => array(
			'title' => 'Featured',
			'type'  => 'checkbox',
			'options' => array(
				'1' => 'Yes',
				'2' => 'No',
				'3' => 'Undecided',
			)
		)    
	);

	$fieldx  = array(
		'name' => array(
			'title' => 'Name',
			'type'  => 'text',
		),
		'gender' => array(
			'title' => 'Feature',
			'type'  => 'radioimage',
			'options' => array(
				'1' => 'http://placeimg.com/100/100/arch',
				'2' => 'http://placeimg.com/100/100/tech',
			),
		),
		'pic' => array(
			'id' => 'profilePic',
			'title' => 'Picture',
			'type'  => 'upload',
		),
	);

	$fieldControl = new Field_Controls();
	$fieldControl->upload('Photo', 'upPhoto', array('name' => 'upPhoto', 'value' => $upPhoto, 'class' => 'single previewImage', 'placeholder' => esc_html__('Image URL' , 'claypress')));
	$fieldControl->upload('License Url', 'upLicense', array('name' => 'upLicense', 'value' => $upLicense, 'class' => 'single previewImage', 'placeholder' => esc_html__('Driving License url' , 'claypress')));

	$fieldControl->text('Name', 'txtName', array('value' => esc_attr( $txtName ), 'attr' => array('data-test1' => 'test1', 'data-validate' => 'true')));
	$fieldControl->text('Website', 'txtWebsite', array('type' => 'url','value' => esc_attr( $txtWebsite )));
	$fieldControl->textarea('Address', 'txtAddress', array('value' => $txtAddress) );
	$fieldControl->select('Transportation?', 'selTrans', array('name' => 'selTrans', 'value' => $selTrans, 'class' => 'widefat chosen-select'), array('car' => 'Car', 'bike' => 'Bike', 'train' => 'Train') );
	$fieldControl->select('Hobby?', 'selHobby', array('name' => 'selHobby', 'multiple' => 'multiple', 'value' => $selHobby, 'class' => 'widefat chosen-select'), array('Out Door' => array('football' => 'Football', 'basketball' => 'Basketball', 'tennis' => 'Tennis', 'swimming' => 'Swimming'), 'Indoor' => array('reading' => 'Reading', 'writing' => 'Writing'), 'Extreme' => array('basejump' => 'Base Jumping', 'surving' => 'Surving', 'diving' => 'Diving')) );
 	$fieldControl->checkbox('Food?', 'chkFood', array('name' => 'chkFood', 'value' => $chkFood, 'class' => 'widefat'), array('fruit' => 'Fruit', 'vegetable' => 'Vegetable', 'bread' => 'Bread') );
 	// $fieldControl->radio('Gender', 'gender', array('name' => 'gender', 'value' => $gender, 'attr' => array('data-test1' => 'test1')), array('male' => 'Male', 'female' => 'Female', 'other' => 'Other'));
 	// $fieldControl->radiopill('Gender', 'gender', array('name' => 'gender', 'value' => $gender, 'attr' => array('data-test1' => 'test1')), array('male' => 'Male', 'female' => 'Female', 'other' => 'Other'));
 	$fieldControl->radioimage('Gender', 'gender', array('name' => 'gender', 'value' => $gender, 'attr' => array('data-test1' => 'test1')), array('male' => 'http://placeimg.com/100/100/nature', 'female' => 'http://placeimg.com/100/100/tech', 'other' => 'http://placeimg.com/100/100/arch'));
 	$fieldControl->colorpicker('Fav Color', 'colorMeta', array('class' => 'widefat', 'value' => $colorMeta,  'attr' => array('data-color' => 'test1')));
 	$fieldControl->editor('About me', 'edAboutMe', array('value' => $edAboutMe), array('textarea_rows' => '5'));
 	
 	// $fieldControl->taxonomy('Category', 'selCats', array('name' =>  'selCats', 'type' => 'select', 'value' => $selCats), 'post_tag', '');
 	$fieldControl->repeaterField('Repeated Feature', 'itemFeatures', array('name' => 'itemFeatures', 'value' => $itemFeatures), $fields);

 	$fieldControl->repeaterField('Personal data', 'rePersonalData', array('name' => 'rePersonalData', 'value' => $rePersonalData), $fieldx);
 	?>
<?php
}

function caviar_meta_box2_callback( $post ) {
	wp_nonce_field( 'caviar_save_meta_box2_data', 'caviar_meta_box2_nonce' );

	$txtDetail      = get_post_meta( $post->ID, '_txtDetail', true );
	$txtArea      	= get_post_meta( $post->ID, '_txtArea', true );

	$fieldy  = array(
		'scenery' => array(
			'id' => 'sceneTitle',
			'title' => 'Scenery',
			'type'  => 'text',
		),
		'pic' => array(
			'id' => 'scenePic',
			'title' => 'Scene Pic',
			'type'  => 'upload',
		),
	);

	$fieldControl = new Field_Controls();
	$fieldControl->upload('Featured', 'upFeatured', array('name' => 'upFeatured', 'value' => $upPhoto, 'class' => 'single previewImage', 'placeholder' => esc_html__('Featured URL' , 'claypress')));
	$fieldControl->editor('Detail', 'txtDetail', array('value' => esc_attr( $txtDetail )));
	$fieldControl->editor('Area', 'txtArea', array('value' => esc_attr( $txtArea )));
	$fieldControl->repeaterField('Scene', 'reScene', array('name' => 'reScene', 'value' => $reScene), $fieldy);
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function caviar_save_meta_box_data( $post_id ) {
	// Sanitize user input.
	$txtname      = sanitize_text_field( $_POST['txtName'] );
	$txtAddress   = $_POST['txtAddress'];
	$selTrans     = $_POST['selTrans'];
	$txtWebsite   = sanitize_text_field( $_POST['txtWebsite'] );
	$chkFood      = $_POST['chkFood'];
	$itemFeatures = $_POST['itemFeatures'];
	$rePersonalData = $_POST['rePersonalData'];
	$gender       = $_POST['gender'];
	$edAboutMe    = $_POST['edAboutMe'];

	$features = array();

	// Update the meta field in the database.
	update_post_meta( $post_id, '_txtName', $txtname );
	update_post_meta( $post_id, '_txtAddress', $txtAddress );
	update_post_meta( $post_id, '_selTrans', $selTrans );
	update_post_meta( $post_id, '_txtWebsite', $txtWebsite );
	update_post_meta( $post_id, '_chkFood', $chkFood );
	update_post_meta( $post_id, '_gender', $gender );
	update_post_meta( $post_id, '_colorMeta', $_POST['colorMeta'] );
	update_post_meta( $post_id, '_selHobby', $_POST['selHobby'] );
	update_post_meta( $post_id, '_edAboutMe', $edAboutMe );
	update_post_meta( $post_id, '_selCats', $_POST['selCats'] );
	update_post_meta( $post_id, '_upPhoto', $_POST['upPhoto'] );
	update_post_meta( $post_id, '_upLicense', $_POST['upLicense'] );

	// var_dump($itemFeatures);
	if ( isset( $itemFeatures ) )
	{
		foreach ( $itemFeatures as $feature )
		{
			if ( '' !== trim( $feature['title'] ) )
				$features[] = $feature;
		}
	}

	update_post_meta( $post_id, '_itemFeatures', $features );


	if ( isset( $rePersonalData ) )
	{
		foreach ( $rePersonalData as $data )
		{
			$pData[] = $data;
		}
	}

	update_post_meta( $post_id, '_rePersonalData', $pData );
}

add_action( 'save_post', 'caviar_save_meta_box_data' );

function caviar_save_meta_box2_data( $post_id ) {
	$txtDetail = $_POST['txtDetail'];
	$txtArea = $_POST['txtArea'];

	// Update the meta field in the database.
	update_post_meta( $post_id, '_txtDetail', $txtDetail );
	update_post_meta( $post_id, '_txtArea', $txtArea );
}

add_action( 'save_post', 'caviar_save_meta_box2_data' );