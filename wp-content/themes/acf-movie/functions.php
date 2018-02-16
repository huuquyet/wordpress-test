<?php

/** Remove Admin Menus */

add_action( 'admin_menu', 'remove_menus' );
function remove_menus() {
  remove_menu_page( 'index.php' );                  //Dashboard
  remove_menu_page( 'edit.php' );                   //Posts
  remove_menu_page( 'edit-comments.php' );          //Comments
  remove_menu_page( 'users.php' );                  //Users
}


/* Reorder Menu Admin */
add_filter('menu_order', 'custom_menu_order');
function custom_menu_order( $menu_ord ) {
    if ( ! $menu_ord ) {
    	return true;
    }

    return array(
        'index.php', // Dashboard
        'separator1', // First separator
        'edit.php?post_type=movie', // Movies
        'edit.php?post_type=actor', // Actors
        'edit.php?post_type=page', // Pages
        'upload.php', // Media
        'separator2', // Second separator
        'themes.php', // Appearance
        'plugins.php', // Plugins
        'users.php', // Users
        'tools.php', // Tools
        'options-general.php', // Settings
        'separator-last', // Last separator
    );
}
add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order


/** Widget Recent Posts with Movie Post Type */
add_filter('widget_posts_args', 'widget_posts_args_add_custom_type');
function widget_posts_args_add_custom_type($params) {
	$params['post_type'] = array('movie');
	return $params;
}


/** Homepage / Category filter shows Movie Custom Post Type */
add_action("pre_get_posts", "custom_front_page");
function custom_front_page($wp_query){
    //Ensure this filter isn't applied to the admin area
    if(is_admin()) {
        return;
    }

    if( is_home() || is_archive() ):

        $wp_query->set('post_type', 'movie');
        $wp_query->set('page_id', ''); //Empty

        //Set properties that describe the page to reflect that
        //we aren't really displaying a static page
        $wp_query->is_page = 0;
        $wp_query->is_singular = 0;
        $wp_query->is_post_type_archive = 1;
        $wp_query->is_archive = 1;

    endif;

}

add_action( 'init', 'leocaseiro_register_ctp' );
function leocaseiro_register_ctp() {
	$labels = array(
		"name" => "Movies",
		"singular_name" => "Movie",
	);

	$args = array(
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"has_archive" => true,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "movie", "with_front" => true ),
		"query_var" => true,
		"menu_icon" => "dashicons-format-video",
		"supports" => array( "title", "editor", "thumbnail", "custom-fields" ),
		"taxonomies" => array( "category" )
	);
	register_post_type( "movie", $args );

	$labels = array(
		"name" => "Actors",
		"singular_name" => "Actor",
	);

	$args = array(
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"has_archive" => true,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "page",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "actor", "with_front" => true ),
		"query_var" => true,
		"menu_icon" => "dashicons-admin-users",
		"supports" => array( "title", "editor", "thumbnail" )
	);
	register_post_type( "actor", $args );

}

/**
 * Instructions
 * Copy the PHP code generated
 * Paste into your functions.php file
 * To activate any Add-ons, edit and use the code in the first few lines.
 *
 * Notes
 * Registered field groups will not appear in the list of editable field groups. This is useful for including fields in themes.
 * Please note that if you export and register field groups within the same WP, you will see duplicate fields on your edit screens. To fix this, please move the original field group to the trash or remove the code from your functions.php file.
 *
 * Include in theme
 * The Advanced Custom Fields plugin can be included within a theme. To do so, move the ACF plugin inside your theme and add the following code to your functions.php file:
 * include_once('advanced-custom-fields/acf.php');
 * To remove all visual interfaces from the ACF plugin, you can use a constant to enable lite mode. Add the following code to your functions.php file before the include_once code:
 * define( 'ACF_LITE', true );
 *
 */


if(function_exists("register_field_group")) {
	register_field_group(array (
		'id' => 'acf_contact-us',
		'title' => 'Contact Us',
		'fields' => array (
			array (
				'key' => 'field_5577adaade5e3',
				'label' => 'Address',
				'name' => 'address',
				'type' => 'textarea',
				'required' => 1,
				'default_value' => '',
				'placeholder' => 'Eq. 200 George St, Sydney NSW 2000, Australia',
				'maxlength' => '',
				'rows' => 4,
				'formatting' => 'br',
			),
			array (
				'key' => 'field_5577addfde5e4',
				'label' => 'Map',
				'name' => 'map',
				'type' => 'google_map',
				'required' => 1,
				'center_lat' => '',
				'center_lng' => '',
				'zoom' => 8,
				'height' => 281,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page',
					'operator' => '==',
					'value' => '2',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'the_content',
				1 => 'excerpt',
				2 => 'custom_fields',
				3 => 'discussion',
				4 => 'comments',
				5 => 'revisions',
				6 => 'slug',
				7 => 'author',
				8 => 'format',
				9 => 'featured_image',
				10 => 'categories',
				11 => 'tags',
				12 => 'send-trackbacks',
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_movie',
		'title' => 'Movie',
		'fields' => array (
			array (
				'key' => 'field_5576eef2ee99b',
				'label' => 'Details',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_55779d2d42b87',
				'label' => 'Release Date in Australia',
				'name' => 'release_date',
				'type' => 'date_picker',
				'required' => 1,
				'date_format' => 'yymmdd',
				'display_format' => 'dd/mm/yy',
				'first_day' => 1,
			),
			array (
				'key' => 'field_5576ebb6c6b80',
				'label' => 'Classification',
				'name' => 'classification',
				'type' => 'radio',
				'required' => 1,
				'choices' => array (
					'General' => 'General',
					'PG - Parental guidance recommended' => 'PG - Parental guidance recommended',
					'M - Recommended for mature audiences' => 'M - Recommended for mature audiences',
					'MA15 - Under 15s must be accompanied by a parent or adult guardian' => 'MA15 - Under 15s must be accompanied by a parent or adult guardian',
					'R18 - Restricted to 18 and over' => 'R18 - Restricted to 18 and over',
					'X18 - Restricted to 18 and over' => 'X18 - Restricted to 18 and over',
					'E - Exempt from Classification' => 'E - Exempt from Classification',
				),
				'other_choice' => 1,
				'save_other_choice' => 1,
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_5576edfec6b81',
				'label' => 'Writer',
				'name' => 'writer',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => 'Written by',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5576ee32c6b82',
				'label' => 'Director',
				'name' => 'director',
				'type' => 'text',
				'instructions' => 'Type the Director',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => 'Directed by',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5576ee5ac6b83',
				'label' => 'Time',
				'name' => 'time',
				'type' => 'number',
				'instructions' => 'Type the time in minutes',
				'required' => 1,
				'default_value' => '',
				'placeholder' => 'Eq. 120',
				'prepend' => '',
				'append' => 'min',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array (
				'key' => 'field_5576ef0cee99c',
				'label' => 'Cast',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_5576ef1bee99d',
				'label' => 'Stars',
				'name' => 'cast',
				'type' => 'relationship',
				'instructions' => 'Choose the actors',
				'required' => 1,
				'return_format' => 'id',
				'post_type' => array (
					0 => 'actor',
				),
				'taxonomy' => array (
					0 => 'all',
				),
				'filters' => array (
					0 => 'search',
				),
				'result_elements' => array (
					0 => 'featured_image',
					1 => 'post_title',
				),
				'max' => '',
			),
			array (
				'key' => 'field_55778bead0509',
				'label' => 'Gallery',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_55779e5afdb91',
				'label' => 'Has Gallery',
				'name' => 'has_gallery',
				'type' => 'true_false',
				'message' => 'Show Gallery',
				'default_value' => 0,
			),
			array (
				'key' => 'field_55778bc2d0508',
				'label' => 'Gallery (free)',
				'name' => 'gallery',
				'type' => 'wysiwyg',
				'instructions' => 'Create a gallery using the Native WP Gallery',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_55779e5afdb91',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_5577917add03c',
				'label' => 'Video',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_557790c57fc14',
				'label' => 'Has Video',
				'name' => 'has_video',
				'type' => 'true_false',
				'message' => 'Show Trailer',
				'default_value' => 0,
			),
			array (
				'key' => 'field_557792a702143',
				'label' => 'Trailer',
				'name' => 'trailer',
				'type' => 'oembed',
				'instructions' => 'Copy an URL from Youtube or Vimeo',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_557790c57fc14',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'preview_size' => 0,
				'returned_size' => 0,
				'returned_format' => 'html',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'movie',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'no_box',
			'hide_on_screen' => array (
				0 => 'excerpt',
				1 => 'discussion',
				2 => 'comments',
				3 => 'revisions',
				4 => 'slug',
				5 => 'author',
				6 => 'format',
				7 => 'send-trackbacks',
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_country',
		'title' => 'Country',
		'fields' => array (
			array (
				'key' => 'field_5577a311ed577',
				'label' => 'Country',
				'name' => 'country',
				'type' => 'select',
				'required' => 1,
				'choices' => array (
					'Afghanistan' => 'Afghanistan',
					'Albania' => 'Albania',
					'Algeria' => 'Algeria',
					'American Samoa' => 'American Samoa',
					'Andorra' => 'Andorra',
					'Angola' => 'Angola',
					'Anguilla' => 'Anguilla',
					'Antigua & Barbuda' => 'Antigua & Barbuda',
					'Argentina' => 'Argentina',
					'Armenia' => 'Armenia',
					'Aruba' => 'Aruba',
					'Australia' => 'Australia',
					'Austria' => 'Austria',
					'Azerbaijan' => 'Azerbaijan',
					'Bahamas, The' => 'Bahamas, The',
					'Bahrain' => 'Bahrain',
					'Bangladesh' => 'Bangladesh',
					'Barbados' => 'Barbados',
					'Belarus' => 'Belarus',
					'Belgium' => 'Belgium',
					'Belize' => 'Belize',
					'Benin' => 'Benin',
					'Bermuda' => 'Bermuda',
					'Bhutan' => 'Bhutan',
					'Bolivia' => 'Bolivia',
					'Bosnia & Herzegovina' => 'Bosnia & Herzegovina',
					'Botswana' => 'Botswana',
					'Brazil' => 'Brazil',
					'British Virgin Is.' => 'British Virgin Is.',
					'Brunei' => 'Brunei',
					'Bulgaria' => 'Bulgaria',
					'Burkina Faso' => 'Burkina Faso',
					'Burma' => 'Burma',
					'Burundi' => 'Burundi',
					'Cambodia' => 'Cambodia',
					'Cameroon' => 'Cameroon',
					'Canada' => 'Canada',
					'Cape Verde' => 'Cape Verde',
					'Cayman Islands' => 'Cayman Islands',
					'Central African Rep.' => 'Central African Rep.',
					'Chad' => 'Chad',
					'Chile' => 'Chile',
					'China' => 'China',
					'Colombia' => 'Colombia',
					'Comoros' => 'Comoros',
					'Congo, Dem. Rep.' => 'Congo, Dem. Rep.',
					'Congo, Repub. of the' => 'Congo, Repub. of the',
					'Cook Islands' => 'Cook Islands',
					'Costa Rica' => 'Costa Rica',
					'Cote d\'Ivoire' => 'Cote d\'Ivoire',
					'Croatia' => 'Croatia',
					'Cuba' => 'Cuba',
					'Cyprus' => 'Cyprus',
					'Czech Republic' => 'Czech Republic',
					'Denmark' => 'Denmark',
					'Djibouti' => 'Djibouti',
					'Dominica' => 'Dominica',
					'Dominican Republic' => 'Dominican Republic',
					'East Timor' => 'East Timor',
					'Ecuador' => 'Ecuador',
					'Egypt' => 'Egypt',
					'El Salvador' => 'El Salvador',
					'Equatorial Guinea' => 'Equatorial Guinea',
					'Eritrea' => 'Eritrea',
					'Estonia' => 'Estonia',
					'Ethiopia' => 'Ethiopia',
					'Faroe Islands' => 'Faroe Islands',
					'Fiji' => 'Fiji',
					'Finland' => 'Finland',
					'France' => 'France',
					'French Guiana' => 'French Guiana',
					'French Polynesia' => 'French Polynesia',
					'Gabon' => 'Gabon',
					'Gambia, The' => 'Gambia, The',
					'Gaza Strip' => 'Gaza Strip',
					'Georgia' => 'Georgia',
					'Germany' => 'Germany',
					'Ghana' => 'Ghana',
					'Gibraltar' => 'Gibraltar',
					'Greece' => 'Greece',
					'Greenland' => 'Greenland',
					'Grenada' => 'Grenada',
					'Guadeloupe' => 'Guadeloupe',
					'Guam' => 'Guam',
					'Guatemala' => 'Guatemala',
					'Guernsey' => 'Guernsey',
					'Guinea' => 'Guinea',
					'Guinea-Bissau' => 'Guinea-Bissau',
					'Guyana' => 'Guyana',
					'Haiti' => 'Haiti',
					'Honduras' => 'Honduras',
					'Hong Kong' => 'Hong Kong',
					'Hungary' => 'Hungary',
					'Iceland' => 'Iceland',
					'India' => 'India',
					'Indonesia' => 'Indonesia',
					'Iran' => 'Iran',
					'Iraq' => 'Iraq',
					'Ireland' => 'Ireland',
					'Isle of Man' => 'Isle of Man',
					'Israel' => 'Israel',
					'Italy' => 'Italy',
					'Jamaica' => 'Jamaica',
					'Japan' => 'Japan',
					'Jersey' => 'Jersey',
					'Jordan' => 'Jordan',
					'Kazakhstan' => 'Kazakhstan',
					'Kenya' => 'Kenya',
					'Kiribati' => 'Kiribati',
					'Korea, North' => 'Korea, North',
					'Korea, South' => 'Korea, South',
					'Kuwait' => 'Kuwait',
					'Kyrgyzstan' => 'Kyrgyzstan',
					'Laos' => 'Laos',
					'Latvia' => 'Latvia',
					'Lebanon' => 'Lebanon',
					'Lesotho' => 'Lesotho',
					'Liberia' => 'Liberia',
					'Libya' => 'Libya',
					'Liechtenstein' => 'Liechtenstein',
					'Lithuania' => 'Lithuania',
					'Luxembourg' => 'Luxembourg',
					'Macau' => 'Macau',
					'Macedonia' => 'Macedonia',
					'Madagascar' => 'Madagascar',
					'Malawi' => 'Malawi',
					'Malaysia' => 'Malaysia',
					'Maldives' => 'Maldives',
					'Mali' => 'Mali',
					'Malta' => 'Malta',
					'Marshall Islands' => 'Marshall Islands',
					'Martinique' => 'Martinique',
					'Mauritania' => 'Mauritania',
					'Mauritius' => 'Mauritius',
					'Mayotte' => 'Mayotte',
					'Mexico' => 'Mexico',
					'Micronesia, Fed. St.' => 'Micronesia, Fed. St.',
					'Moldova' => 'Moldova',
					'Monaco' => 'Monaco',
					'Mongolia' => 'Mongolia',
					'Montserrat' => 'Montserrat',
					'Morocco' => 'Morocco',
					'Mozambique' => 'Mozambique',
					'Namibia' => 'Namibia',
					'Nauru' => 'Nauru',
					'Nepal' => 'Nepal',
					'Netherlands' => 'Netherlands',
					'Netherlands Antilles' => 'Netherlands Antilles',
					'New Caledonia' => 'New Caledonia',
					'New Zealand' => 'New Zealand',
					'Nicaragua' => 'Nicaragua',
					'Niger' => 'Niger',
					'Nigeria' => 'Nigeria',
					'N. Mariana Islands' => 'N. Mariana Islands',
					'Norway' => 'Norway',
					'Oman' => 'Oman',
					'Pakistan' => 'Pakistan',
					'Palau' => 'Palau',
					'Panama' => 'Panama',
					'Papua New Guinea' => 'Papua New Guinea',
					'Paraguay' => 'Paraguay',
					'Peru' => 'Peru',
					'Philippines' => 'Philippines',
					'Poland' => 'Poland',
					'Portugal' => 'Portugal',
					'Puerto Rico' => 'Puerto Rico',
					'Qatar' => 'Qatar',
					'Reunion' => 'Reunion',
					'Romania' => 'Romania',
					'Russia' => 'Russia',
					'Rwanda' => 'Rwanda',
					'Saint Helena' => 'Saint Helena',
					'Saint Kitts & Nevis' => 'Saint Kitts & Nevis',
					'Saint Lucia' => 'Saint Lucia',
					'St Pierre & Miquelon' => 'St Pierre & Miquelon',
					'Saint Vincent and the Grenadines' => 'Saint Vincent and the Grenadines',
					'Samoa' => 'Samoa',
					'San Marino' => 'San Marino',
					'Sao Tome & Principe' => 'Sao Tome & Principe',
					'Saudi Arabia' => 'Saudi Arabia',
					'Senegal' => 'Senegal',
					'Serbia' => 'Serbia',
					'Seychelles' => 'Seychelles',
					'Sierra Leone' => 'Sierra Leone',
					'Singapore' => 'Singapore',
					'Slovakia' => 'Slovakia',
					'Slovenia' => 'Slovenia',
					'Solomon Islands' => 'Solomon Islands',
					'Somalia' => 'Somalia',
					'South Africa' => 'South Africa',
					'Spain' => 'Spain',
					'Sri Lanka' => 'Sri Lanka',
					'Sudan' => 'Sudan',
					'Suriname' => 'Suriname',
					'Swaziland' => 'Swaziland',
					'Sweden' => 'Sweden',
					'Switzerland' => 'Switzerland',
					'Syria' => 'Syria',
					'Taiwan' => 'Taiwan',
					'Tajikistan' => 'Tajikistan',
					'Tanzania' => 'Tanzania',
					'Thailand' => 'Thailand',
					'Togo' => 'Togo',
					'Tonga' => 'Tonga',
					'Trinidad & Tobago' => 'Trinidad & Tobago',
					'Tunisia' => 'Tunisia',
					'Turkey' => 'Turkey',
					'Turkmenistan' => 'Turkmenistan',
					'Turks & Caicos Is' => 'Turks & Caicos Is',
					'Tuvalu' => 'Tuvalu',
					'Uganda' => 'Uganda',
					'Ukraine' => 'Ukraine',
					'United Arab Emirates' => 'United Arab Emirates',
					'United Kingdom' => 'United Kingdom',
					'United States' => 'United States',
					'Uruguay' => 'Uruguay',
					'Uzbekistan' => 'Uzbekistan',
					'Vanuatu' => 'Vanuatu',
					'Venezuela' => 'Venezuela',
					'Vietnam' => 'Vietnam',
					'Virgin Islands' => 'Virgin Islands',
					'Wallis and Futuna' => 'Wallis and Futuna',
					'West Bank' => 'West Bank',
					'Western Sahara' => 'Western Sahara',
					'Yemen' => 'Yemen',
					'Zambia' => 'Zambia',
					'Zimbabwe' => 'Zimbabwe',
				),
				'default_value' => 'United States',
				'allow_null' => 0,
				'multiple' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'movie',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'actor',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 2,
	));
}
