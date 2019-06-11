<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Add includes and requires
//if(!function_exists('wp_get_current_user')) {
//    include(ABSPATH . "wp-includes/pluggable.php");
//}

/*
Plugin Name:  xenial
Plugin URI:   https://xenial.trimwebdesign.com
Description:  Custom Schema
Header Comment
Version:      1.1.10
Author:       Joshua Trimm
Author URI:   https://trimwebdesign.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  trimwebdesign
Domain Path:  /languages

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Define plugin version
define("XENIAL_VERSION", "1.1.10");

//Define plugin path slug
define("XENIAL_PLUGINPATH", "/" . plugin_basename(dirname(__FILE__)) . "/");

//Define the plugin full url
define("XENIAL_PLUGINFULLURL", trailingslashit(plugins_url('xenial-WP.php', __FILE__)));

//Define the plugin full dir
define("XENIAL_PLUGINFULLDIR", WP_PLUGIN_DIR . XENIAL_PLUGINPATH);

//Define the global var XENIALWP1, returing bool if WP 7.0 or higher is running
define('XENIALWP1', version_compare($GLOBALS['wp_version'], '6.9.999', '>'));



/**
 * The XenialForWPAdmin
 *
 * @package        WordPress_Plugins
 * @subpackage    XenialForWPAdmin
 * @since        1.1.10
 * @author        Joshua Trimm
 */

register_activation_hook(__FILE__, 'xwp_activation');
/**
 * xwp_activation
 * void
 * Description: Setup database upon activation of the plugin
 */
function xwp_activation()
{
    //include global config
    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;

    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    if ($wpdb->get_var('SHOW TABLES LIKE' . $table_name) != $table_name) {
        $sql = 'CREATE TABLE ' . $table_name . '(
            id int NOT NULL AUTO_INCREMENT,
            addressLocality VARCHAR(100),
            addressRegion TEXT(100),
            postalCode INT(55),
            streetAddress VARCHAR(100),
            pages VARCHAR(255),
            paymentAccepted VARCHAR(255),
            openingHours VARCHAR(255),
            priceRange VARCHAR(255),
            brands VARCHAR(255),
            description VARCHAR(255),
            email VARCHAR(255),
            telephone VARCHAR(255),
            PRIMARY KEY (id)         
        )';

        $initializePages = "INSERT INTO `" . $table_name . "` (`id`, `addressLocality`, `addressRegion`, `postalCode`, `streetAddress`, `pages`, `paymentAccepted`, `image`) VALUES ('1', NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
        $initializePost = "INSERT INTO `" . $table_name . "` (`id`, `addressLocality`, `addressRegion`, `postalCode`, `streetAddress`, `pages`, `paymentAccepted`, `image`) VALUES ('2', NULL, NULL, NULL, NULL, NULL, NULL, NULL)";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);

        dbDelta($initializePages);

        dbDelta($initializePost);


        add_option('xenial_database_version', '1.0.1');
    }
	flush_rewrite_rules();


}




function xwp_Update_Database()
{
    global $wpdb;

    //include_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $pagesType = $wpdb->get_results('DESCRIBE wp_schemaLocalBusiness pages');
    $pagesTypeImage = $wpdb->get_results('DESCRIBE wp_schemaLocalBusiness pages');

    $table_name = $wpdb->prefix . "schemaLocalBusiness";


    if ($pagesType[0]->Types != 'varchar(255)') {
        $updateDatabase = $wpdb->query('ALTER TABLE `' . $table_name . '` MODIFY COLUMN `pages` VARCHAR(255);');

        dbDelta($updateDatabase);

    }

    if ($pagesTypeImage[0]->Types != 'varchar(255)')
    {
        $updateDatabase = $wpdb->query('ALTER TABLE `' . $table_name . '` ADD `image` VARCHAR(255);');

        dbDelta($updateDatabase);
    }

}

register_activation_hook(__FILE__, 'xwp_Update_Database');

/**
 * xwp_insert_scripts
 * void
 *
 *
 * Description: Runs all the javascript for xenial.
 *
 */
function xwp_insert_scripts()
{
//    wp_enqueue_script('jquery', '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>', '1.0.0', true);
//
//    wp_enqueue_script( 'schemaNav', plugin_dir_url( __FILE__ ) . 'js/schemaNav.js', array('jquery'), '1.0.0', true );
//    wp_enqueue_script( 'lazyLoad', plugin_dir_url( __FILE__ ) . 'js/lazyLoad.js', array('jquery'), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'xwp_insert_scripts' );


/**
 * xwp_insert_admin_scripts
 * void
 * Description: enqueue scripts for admin side
 *
 *
 */
function xwp_insert_admin_scripts() {
	//var_dump(plugin_dir_url( __FILE__ ));

    wp_enqueue_script( 'check_all_pages_xenial', plugin_dir_url( __FILE__ ) . 'js/checkAllPages.js' );
    wp_enqueue_script( 'openTabs', plugin_dir_url( __FILE__) . 'js/openTabs.js');
    wp_enqueue_script( 'check_all_payment_types', plugin_dir_url( __FILE__ ) . 'js/checkAllPaymentTypes.js' );
}
add_action( 'admin_enqueue_scripts', 'xwp_insert_admin_scripts' );

/**
 * xwp_xenial_menu
 * void
 * Description: Function is used to input menu information for the plugin
 *
 *
 */
function xwp_xenial_menu()
{
    if (is_admin()) {
        //local variables for main menu
        $page_title = 'Xenial Page Title';
        $menu_title = 'Xenial';
        $capability = 'administrator';
        $menu_slug = 'xenial-information.php';
        $function = 'xwp_xenial_menu';
        $icon_url = 'dashicons-media-code';
        $position = 7;

        //local variables for settings page
        $parent_slug = 'xenial-information.php';


        //Menu variables for schema page
        $schemaLocalBusiness_page_title = 'Xenial Page Schema';
        $schemaLocalBusiness_menu_title = 'Page Schema';
        $sub_schemaLocalBusiness_slug = 'schema.php';

        //Menu variables for xwp-post page
        $schemaPost_page_title = 'Xenial Post Schema';
        $schemaPost_menu_title = 'Post Schema';
        $sub_schemaPost_slug = 'xwp-post-schema.php';

        //Menu variables for xwp-custom-robots.php
        $robotsTxt_page_title = 'Xenial Custom Robots.txt';
        $robotsTxt_menu_title = 'Robots.txt';
        $sub_robotsTxt_slug = 'xwp-custom-robots.php';





        //Main menu on left side
        add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);


        //submenu for Schema Local Business infromation page
        add_submenu_page($parent_slug, $schemaLocalBusiness_page_title, $schemaLocalBusiness_menu_title, $capability, $sub_schemaLocalBusiness_slug, $function);

        //Add xwp-post to menue
        add_submenu_page($parent_slug, $schemaPost_page_title, $schemaPost_menu_title, $capability, $sub_schemaPost_slug, $function);

        //Add xwp-custom-robots to menue
        add_submenu_page($parent_slug, $robotsTxt_page_title, $robotsTxt_menu_title, $capability, $sub_robotsTxt_slug, $function);


    }
}

//action hook for the xenial menu
add_action('admin_menu', 'xwp_xenial_menu');


/**
 * xwp_start_xenial_pages
 * void
 * Description: Addes the page address for xwp_xenial_menu()
 */
function xwp_start_xenial_pages()
{
	$page = '';
	if(isset($_GET['page']))
	{
		$page = $_GET['page'];
	}

    //var_dump($page);
    if (!strcmp($page, 'xenial-information.php')) {

        include_once 'xenial-information.php';

    } elseif (!strcmp($page, 'schema.php')) {
        include_once 'schema.php';
    } elseif (!strcmp($page, 'xwp-post-schema.php')) {
        include_once 'xwp-post-schema.php';
    } elseif (!strcmp($page, 'xwp-twitter-automation.php')){
        include_once 'xwp-twitter-automation.php';
    } elseif (!strcmp($page, 'xwp-sitemap.php')) {
        include_once 'xwp-sitemap.php';
    } elseif (!strcmp($page, 'xwp-custom-robots.php')){
    	include_once 'xwp-custom-robots.php';
    }
}

add_action('all_admin_notices', 'xwp_start_xenial_pages');

/**
 * xwp_start_xenial_css
 * void
 * Description: enqueue styles
 */
function xwp_start_xenial_css()
{

    if (is_admin()) {
        include_once 'css/xenial-style.css';
    }
}

add_action('admin_head', 'xwp_start_xenial_css');


/**
 * xwp_getPageIDs
 * void
 * Description: This function retries all the pages from the database. And this is used to select what pages the user
 * would like the schema to appear on.
 */
function xwp_getPageIDs()
{
    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;

    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $row = $wpdb->get_row('SELECT pages FROM ' . $table_name . 'WHERE id = 1');


    $pageIDs = $row->pages;

    $pageIDsArray = explode(" ", $pageIDs);

    foreach ($pageIDsArray as $page) {

        echo $page;

    }

}




/**
 * xwp_openTime
 * void
 * Description: Designed to echo opening time options
 */
function xwp_openTime()
{
    echo '<option value="8:00 AM">8:00 AM</option>
    <option value="8:30 AM">8:30 AM</option>
    <option value="9:00 AM">9:00 AM</option>
    <option value="9:30 AM">9:30 AM</option>
    <option value="10:00 AM">10:00 AM</option>
    <option value="10:30 AM">10:30 AM</option>
    <option value="11:00 AM">11:00 AM</option>
    <option value="11:30 AM">11:30 AM</option>
    <option value="CLOSED">CLOSED</option>';
}


/**
 * xwp_closeTime
 * void
 * Description: Design to echo closing time options
 */
function xwp_closeTime()
{
    echo '<option value="12:00 PM">12:00 PM</option>
    <option value="12:30 PM">12:30 PM</option>
    <option value="1:00 PM">1:00 PM</option>
    <option value="1:30 PM">1:30 PM</option>
    <option value="2:00 PM">2:00 PM</option>
    <option value="2:30 PM">2:30 PM</option>
    <option value="3:00 PM">3:00 PM</option>
    <option value="3:30 PM">3:30 PM</option>
    <option value="4:00 PM">4:00 PM</option>
    <option value="4:30 PM">4:30 PM</option>
    <option value="5:00 PM">5:00 PM</option>
    <option value="5:30 PM">5:30 PM</option>
    <option value="6:00 PM">6:00 PM</option>
    <option value="6:30 PM">6:30 PM</option>
    <option value="7:00 PM">7:00 PM</option>
    <option value="7:30 PM">7:30 PM</option>
    <option value="8:00 PM">8:00 PM</option>
    <option value="8:30 PM">8:30 PM</option>
    <option value="9:00 PM">9:00 PM</option>
    <option value="9:30 PM">9:30 PM</option>
    <option value="10:00 PM">10:00 PM</option>
    <option value="10:30 PM">10:30 PM</option>
    <option value="11:00 PM">11:00 PM</option>
    <option value="11:30 PM">11:30 PM</option>
    <option value="CLOSED">CLOSED</option>';
}


/**
 * xwp_insertLocalBusinessSchema
 * void
 * Description: This function is responsible for inserting all the required data into the database for the schema.
 */
function xwp_insertLocalBusinessSchema()
{
    //include global config
    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;

    //set global sessions for opening and closing times
    $mondayOpen = sanitize_text_field($_SESSION['MondayOpen']);
    $mondayClose = sanitize_text_field($_SESSION['MondayClose']);
    $tuesdayOpen = sanitize_text_field($_SESSION['TuesdayOpen']);
    $tuesdayClose = sanitize_text_field($_SESSION['TuesdayClose']);
    $wednesdayOpen = sanitize_text_field($_SESSION['WednesdayOpen']);
    $wednesdayClose = sanitize_text_field($_SESSION['WednesdayClose']);
    $thursdayOpen = sanitize_text_field($_SESSION['ThursdayOpen']);
    $thursdayClose = sanitize_text_field($_SESSION['ThursdayClose']);
    $fridayOpen = sanitize_text_field($_SESSION['FridayOpen']);
    $fridayClose = sanitize_text_field($_SESSION['FridayClose']);
    $saturdayOpen = sanitize_text_field($_SESSION['SaturdayOpen']);
    $saturdayClose = sanitize_text_field($_SESSION['SaturdayClose']);
    $sundayOpen = sanitize_text_field($_SESSION['SundayOpen']);
    $sundayClose = sanitize_text_field($_SESSION['SundayClose']);

    $pages = sanitize_text_field(implode(',', $_SESSION['pages']));

    $paymentAccepted = sanitize_text_field(implode(',', $_SESSION['paymentAccepted']));

    //instert openingHours formate
    $openingHours = 'Monday: ' . $mondayOpen . '-' . $mondayClose . ', Tuesday: ' . $tuesdayOpen . '-' . $tuesdayClose . ', Wednesday: ' . $wednesdayOpen . '-' . $wednesdayClose . ', Thursday: ' . $thursdayOpen . '-' . $thursdayClose . ', Friday: ' . $fridayOpen . '-' . $fridayClose . ', Saturday: ' . $saturdayOpen . '-' . $saturdayClose . ', Sunday: ' . $sundayOpen . '-' . $sundayClose;

    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    var_dump($_SESSION['image']);

    $insert = "UPDATE " . $table_name . " SET addressLocality = '" . sanitize_text_field($_SESSION['addressLocality']) . "', addressRegion = '" . sanitize_text_field($_SESSION['addressRegion']) . "', postalCode = '" . sanitize_text_field($_SESSION['postalCode']) . "', streetAddress = '" . sanitize_text_field($_SESSION['streetAddress']) . "', pages = '" . $pages . "', paymentAccepted = '" . $paymentAccepted . "', openingHours = '" . $openingHours . "', priceRange = '" . sanitize_text_field($_SESSION['priceRange']) . "', brands = '" . sanitize_text_field($_SESSION['brands']) . "', description = '" . sanitize_text_field($_SESSION['description']) . "', email = '" . sanitize_email($_SESSION['email']) . "', telephone = '" . sanitize_text_field($_SESSION['telephone']) . "', image = '" . sanitize_text_field($_SESSION['image']) . "' WHERE id = 1";

    $wpdb->query($insert);

}

function xwp_insertPostSchema()
{
    //include global config
    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;

    //set global sessions for opening and closing times
    $mondayOpen = sanitize_text_field($_SESSION['MondayOpen']);
    $mondayClose = sanitize_text_field($_SESSION['MondayClose']);
    $tuesdayOpen = sanitize_text_field($_SESSION['TuesdayOpen']);
    $tuesdayClose = sanitize_text_field($_SESSION['TuesdayClose']);
    $wednesdayOpen = sanitize_text_field($_SESSION['WednesdayOpen']);
    $wednesdayClose = sanitize_text_field($_SESSION['WednesdayClose']);
    $thursdayOpen = sanitize_text_field($_SESSION['ThursdayOpen']);
    $thursdayClose = sanitize_text_field($_SESSION['ThursdayClose']);
    $fridayOpen = sanitize_text_field($_SESSION['FridayOpen']);
    $fridayClose = sanitize_text_field($_SESSION['FridayClose']);
    $saturdayOpen = sanitize_text_field($_SESSION['SaturdayOpen']);
    $saturdayClose = sanitize_text_field($_SESSION['SaturdayClose']);
    $sundayOpen = sanitize_text_field($_SESSION['SundayOpen']);
    $sundayClose = sanitize_text_field($_SESSION['SundayClose']);

    $pages = sanitize_text_field(implode(',', $_SESSION['pages']));

    $paymentAccepted = sanitize_text_field(implode(',', $_SESSION['paymentAccepted']));

    //instert openingHours formate
    $openingHours = 'Monday: ' . $mondayOpen . '-' . $mondayClose . ', Tuesday: ' . $tuesdayOpen . '-' . $tuesdayClose . ', Wednesday: ' . $wednesdayOpen . '-' . $wednesdayClose . ', Thursday: ' . $thursdayOpen . '-' . $thursdayClose . ', Friday: ' . $fridayOpen . '-' . $fridayClose . ', Saturday: ' . $saturdayOpen . '-' . $saturdayClose . ', Sunday: ' . $sundayOpen . '-' . $sundayClose;

    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    // $insert = "UPDATE " . $table_name . " SET addressLocality = '" . sanitize_text_field($_SESSION['addressLocality']) . "', addressRegion = '" . sanitize_text_field($_SESSION['addressRegion']) . "', postalCode = '" . sanitize_text_field($_SESSION['postalCode']) . "', streetAddress = '" . sanitize_text_field($_SESSION['streetAddress']) . "', pages = '" . $pages . "', paymentAccepted = '" . $paymentAccepted . "', openingHours = '" . $openingHours . "', priceRange = '" . sanitize_text_field($_SESSION['priceRange']) . "', brands = '" . sanitize_text_field($_SESSION['brands']) . "', description = '" . sanitize_text_field($_SESSION['description']) . "', email = '" . sanitize_email($_SESSION['email']) . "', telephone = '" . sanitize_text_field($_SESSION['telephone']) . "' WHERE id = 2";

    //var_dump($pages);
    //$wpdb->query($insert);

    $wpdb->update(
        $table_name,
        array(
            'addressLocality' => sanitize_text_field($_SESSION['addressLocality']),
            'addressRegion' =>  sanitize_text_field($_SESSION['addressRegion']),
            'postalCode' => sanitize_text_field($_SESSION['postalCode']),
            'streetAddress' => sanitize_text_field($_SESSION['streetAddress']),
            'pages' =>  " . $pages . ",
            'paymentAccepted' => $paymentAccepted ,
            'openingHours' => ". $openingHours . ",
            'priceRange' => sanitize_text_field($_SESSION['priceRange']),
            'brands' => sanitize_text_field($_SESSION['brands']),
            'description' => sanitize_text_field($_SESSION['description']),
            'email' => sanitize_email($_SESSION['email']),
            'telephone' => sanitize_text_field($_SESSION['telephone']),
            'image' => sanitize_text_field($_SESSION['image']),

        ),
        array( 'ID' => 2)
    );

}


/**
 * xwp_selectPages
 * void
 * Description: Select pages for schema to display on
 */
function xwp_selectPages()
{

    //$page_ids = get_posts(array(
    //    'fields'          => 'ids', // Only get post IDs
    //    'posts_per_page'  => -1
    //));;

    $page_ids = get_all_page_ids();

    echo '<h3>My Page List :</h3>';
    echo '<br>';
    echo '<input type="checkbox" name="checkCon" onclick="selectAllPages(this)" ><strong>Check all boxes</strong>';

    foreach ($page_ids as $page) {
        echo '<br>';
        echo '<input type="checkbox" name="pages[]" value="' . $page . '">' . ' ' . get_the_title($page) . ' ';
    }
}

/**
 * xwp_selectPosts
 * void
 * Description:
 */
function xwp_selectPosts()
{

    $page_ids = get_posts(array(
        'numberposts' => -1
    ));

    //var_dump($page_ids);

    echo '<h3>My Post List :</h3>';
    echo '<br>';
    echo '<input type="checkbox" name="checkCon" onclick="selectAllPages(this)">' . ' <strong>Check all boxes</strong>';

    foreach ($page_ids as $page => $value) {
        echo '<br>';
        echo '<input type="checkbox" name="pages[]" value="' . $value -> ID . '">' . ' ' . get_the_title($value -> ID) . ' ';
    }
}


/**
 * xwp_paymentAccepted
 * void
 * Description: This turns the paymentAccepted checkboxes into an array so the can be inserted into the database
 */
function xwp_paymentAccepted()
{

    if (isset($_SESSION['paymentAccepted'])) {
        $paymentAccepted = implode(",", $_SESSION['paymentAccepted']);

    }

}

/**
 * xwp_selectAllFromDatabase
 * void
 * Description: Selects all the results from schemaLocalBusiness table to be displayed for used to see
 */
function xwp_selectAllFromDatabase()
{
    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;

    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM " . $table_name . " ";

    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[] = $results;
    }


    $addressLocality = $row[0]->addressLocality;
    $addressRegion = $row[0]->addressRegion;
    $postalCode = $row[0]->postalCode;
    $streetAddress = $row[0]->streetAddress;
    $paymentAccepted = $row[0]->paymentAccepted;
    $openingHours = $row[0]->openingHours;
    $priceRange = $row[0]->priceRange;
    $brands = $row[0]->brands;
    $description = $row[0]->description;
    $email = $row[0]->email;
    $telephone = $row[0]->telephone;

    //print_r($schemaQuery);

    //var_dump($schemaQuery);

    //echo $addressLocality;
}



function xwp_getLogoForSchema()
{
    $logo = the_custom_logo();
    echo $logo;
}

/**
 * xwp_displayCustomSchema
 * void
 * Description: Structures the Page schema information to be display on the frontend.
 */
function xwp_displayCustomSchema()
{

//get website title
    $title = get_bloginfo('name');
    $post = [];

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;

    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "`";

    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[] = $results;
    }

    //print_r($row);

    $addressLocality = $row[0]->addressLocality;
    $addressRegion = $row[0]->addressRegion;
    $postalCode = $row[0]->postalCode;
    $streetAddress = $row[0]->streetAddress;
    $paymentAccepted = $row[0]->paymentAccepted;
    $openingHours = $row[0]->openingHours;
    $priceRange = $row[0]->priceRange;
    $brands = $row[0]->brands;
    $description = $row[0]->description;
    $email = $row[0]->email;
    $telephone = $row[0]->telephone;
    $image = $row[0]->image;

    $page = $row[0]->pages;

    $exploding = explode(",", $page);

    //var_dump($exploding);


    if (is_page($exploding)) {

        echo '<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "localBusiness",
  "name": "' . $title . '",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "' . $addressLocality . '",
    "addressRegion": "' . $addressRegion . '",
    "postalCode": "' . $postalCode . '",
    "streetAddress": "' . $streetAddress . '"
  },
  "description": "' . $description . '",
  "openingHours": "' . $openingHours . '",
  "telephone": "' . $telephone . '",
  "email": "' . $email . '",
  "priceRange": "' . $priceRange . '",
  "image": "' . $image . '",
  "brand": "' . $brands . '",
  "paymentAccepted": "' . $paymentAccepted . '"
}
</script>';
    }
}

add_action('wp_footer', 'xwp_displayCustomSchema');

/**
 * xwp_displayPostSchema
 * void
 * Description: This functions inserts Post Schema data into the frontend of the website.
 */
function xwp_displayPostSchema()
{

//get website title
    $title = get_bloginfo('name');

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;

    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 2";

    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
    }

    //print_r($row);

    $addressLocality = $row[1]->addressLocality;
    $addressRegion = $row[1]->addressRegion;
    $postalCode = $row[1]->postalCode;
    $streetAddress = $row[1]->streetAddress;
    $paymentAccepted = $row[1]->paymentAccepted;
    $openingHours = $row[1]->openingHours;
    $priceRange = $row[1]->priceRange;
    $brands = $row[1]->brands;
    $description = $row[1]->description;
    $email = $row[1]->email;
    $telephone = $row[1]->telephone;
    $image = $row[1]->image;

    $posts = $row[1]->pages;


    $exploding = explode(",", $posts);

    //var_dump($exploding);


    // foreach($posts as $post)
    // {
    if (is_single($exploding)) {

        echo '<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "localBusiness",
  "name": "' . $title . '",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "' . $addressLocality . '",
    "addressRegion": "' . $addressRegion . '",
    "postalCode": "' . $postalCode . '",
    "streetAddress": "' . $streetAddress . '"
  },
  "description": "' . $description . '",
  "openingHours": "' . $openingHours . '",
  "telephone": "' . $telephone . '",
  "email": "' . $email . '",
  "priceRange": "' . $priceRange . '",
  "image": "' . $image . '",
  "brand": "' . $brands . '",
  "paymentAccepted": "' . $paymentAccepted . '"
}
</script>';
    }
    // }


}

add_action('wp_footer', 'xwp_displayPostSchema');

/**
 * xwp_json_Page_schema
 * void
 * Description:Display current json schema settings for user to view at the bottom of the page on admin side.
 */
function xwp_json_Page_schema()
{

    //get website title
    $title = get_bloginfo('name');

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;


    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "`";

    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[] = $results;
    }

    //print_r($row);

    $addressLocality = $row[0]->addressLocality;
    $addressRegion = $row[0]->addressRegion;
    $postalCode = $row[0]->postalCode;
    $streetAddress = $row[0]->streetAddress;
    $paymentAccepted = $row[0]->paymentAccepted;
    $openingHours = $row[0]->openingHours;
    $priceRange = $row[0]->priceRange;
    $brands = $row[0]->brands;
    $description = $row[0]->description;
    $email = $row[0]->email;
    $telephone = $row[0]->telephone;
    $image = $row[0]->image;

    echo '
  "@context": "http://schema.org",<br>
  "@type": "localBusiness",<br>
  "name": "' . $title . '",<br>
  "address": {<br>
    "@type": "PostalAddress",<br>
    "addressLocality": "' . $addressLocality . '",<br>
    "addressRegion": "' . $addressRegion . '",<br>
    "postalCode": "' . $postalCode . '",<br>
    "streetAddress": "' . $streetAddress . '"<br>
  },<br>
  "description": "' . $description . '",<br>
  "openingHours": "' . $openingHours . '",<br>
  "telephone": "' . $telephone . '",<br>
  "email": "' . $email . '",<br>
  "priceRange": "' . $priceRange . '",<br>
  "image": "' . $image . '",<br>
  "brand": "' . $brands . '",<br>
  "paymentAccepted": "' . $paymentAccepted . '"
}
';
}

/**
 * xwp_json_Post_schema
 * void
 * Description: Displays Post schema settings for user to view on the admin side.
 */
function xwp_json_Post_schema()
{

    //get website title
    $title = get_bloginfo('name');



    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 2";


    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);

    $addressLocality = $row[1]->addressLocality;
    $addressRegion = $row[1]->addressRegion;
    $postalCode = $row[1]->postalCode;
    $streetAddress = $row[1]->streetAddress;
    $paymentAccepted = $row[1]->paymentAccepted;
    $openingHours = $row[1]->openingHours;
    $priceRange = $row[1]->priceRange;
    $brands = $row[1]->brands;
    $description = $row[1]->description;
    $email = $row[1]->email;
    $telephone = $row[1]->telephone;
    $image = $row[1]->image;

    //var_dump($priceRange);

    echo '
  "@context": "http://schema.org",<br>
  "@type": "localBusiness",<br>
  "name": "' . $title . '",<br>
  "address": {<br>
    "@type": "PostalAddress",<br>
    "addressLocality": "' . $addressLocality . '",<br>
    "addressRegion": "' . $addressRegion . '",<br>
    "postalCode": "' . $postalCode . '",<br>
    "streetAddress": "' . $streetAddress . '"<br>
  },<br>
  "description": "' . $description . '",<br>
  "openingHours": "' . $openingHours . '",<br>
  "telephone": "' . $telephone . '",<br>
  "email": "' . $email . '",<br>
  "priceRange": "' . $priceRange . '",<br>
  "image": "' . $image . '",<br>
  "brand": "' . $brands . '",<br>
  "paymentAccepted": "' . $paymentAccepted . '"
}
';
}

/**
 * js_defer_attr
 * mixed
 * Description: Deffers JavaScript unless it if from xenial or jquery
 * *
 * @return mixed
 * @param $tag
 *
 */

//add_action( 'script_loader_tag', 'js_defer_attr', 10, 3);

function js_defer_attr( $tag, $handle)
{
    $xenialurl = 'xenial';
    $check = strpos($handle, $xenialurl);
    $jqueryurl = 'jquery';
    $checkForJquery = strpos($handle, $jqueryurl);
    $diviUrl = 'divi';
    $checkForDivi = strpos($handle, $diviUrl);


    if($check == false OR $checkForJquery == false)
    {
        // add defer to all  scripts tags
        return str_replace( ' src', ' defer="defer" src', $tag );
    }
    else
    {
        return str_replace( ' src', ' async src', $tag );
    }

}



//part of function is_logged_in()
//add_action('init','is_logged_in');
/**
 * is_logged_in
 * bool
 * Description: Checks to see if users are logged in
 * @return boolean
 *
 */
//function is_logged_in()
//{
//    var_dump(wp_get_current_user()->ID);
//    var_dump(get_current_user_id());
//    if ( get_current_user_id() == 0 )
//    {
//        return false;
//    }
//
//    return true;
//}
//
///**
// * minify_html
// * null|string|string[]
// * Description:
// * *
// * @return null|string|string[]
// * @param $minify
// *
// */
//if(is_logged_in() != 0)
//{
//    function minify_html($minify)
//    {
//        $search = array(
//            '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
//            '/[^\S ]+\</s',  // strip whitespaces before tags, except space
//            '/(\s)+/s'       // shorten multiple whitespace sequences
//        );
//        $replace = array(
//            '>',
//            '<',
//            '\\1'
//        );
//        $minify = preg_replace($search, $replace, $minify);
//        return $minify;
//    }
//
//    ob_start("minify_html");
//    add_action('get_header', 'minify_html');
//}


// Remove WP Version From Styles
add_filter('style_loader_src', 'xwp_remove_ver_css_js', 9999);

// Remove WP Version From Scripts
add_filter('script_loader_src', 'xwp_remove_ver_css_js', 9999);

/**
 * xwp_remove_ver_css_js
 * string
 * Description: Removes version number strings from css and js file urls
 *
 * @return string
 * @param $src
 *
 */
function xwp_remove_ver_css_js($src)
{
    if (strpos($src, 'ver='))
        $src = remove_query_arg('ver', $src);
    return $src;
}

/**
 * xwp_custom_robots_dot_txt
 * void
 * Description: DEPRICATED creates a robots.txt file in the public_html directory and writes a file called robots.txt allowing only google to crawl website.
 *
 *
 */
function xwp_custom_robots_dot_txt()
{
    $path = get_home_path();

    echo "<p>Where the robots.txt was placed: " . $path . "</p>";

    $myfile = fopen($path . "robots.txt", "w") or die("Unable to open file!");

    $txt = "User-agent: Googlebot\nDisallow: /wp-admin\n\nUser-agent: *\nDisallow: /wp-admin ";

    echo "<p>What was wrote to robots.txt: " . $txt ."</p>";

    fwrite($myfile, $txt);

    fclose($myfile);
}

/**
 * xwp_get_all_post_ids
 * void
 * Description: Get and returns all the Post IDs in the form of an array
 *
 *
 */
function xwp_get_all_post_ids()
{

    $postIdArray = array();

    $query = new WP_Query( 'p' );
    foreach($query as $postIds)
    {
        //var_dump($postIds);
    }


    if ( $query->have_posts() )
    {
        // The 2nd Loop
        while ( $query->have_posts() )
        {
            $query->the_post();
            //echo '<li>' . $query->post->ID  . '</li>';
            array_push($postIdArray, $query->post->ID);
        }

        // Restore original Post Data
        wp_reset_postdata();
        return $postIdArray;
    }
}

/**
 * xwp_get_permalinks_from_ID_array
 * array
 * Description: turns page or post ID's into permalinks
 * * @param $array
 *
 */
function xwp_get_permalinks_from_ID_array( $array )
{
    $permalinkArray = array();
    foreach ($array as $id)
    {
        $getPermalinks = get_permalink($id);
        array_push($permalinkArray, $getPermalinks);
    }
    return $permalinkArray;
}


add_action( "save_post", "xwp_create_sitemap" );
/**
 * xwp_create_sitemap
 * void
 * Description: Generates sitemap in xml format
 *
 *
 */
function xwp_create_sitemap() {
    $postsForSitemap = get_posts( array(
        'numberposts' => -1,
        'orderby'     => 'modified',
        'post_type'   => array( 'post', 'page' ),
        'order'       => 'DESC'
    ) );
    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
    $sitemap .= "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach( $postsForSitemap as $post ) {
        setup_postdata( $post );
        $postdate = explode( " ", $post->post_modified );
        $sitemap .= "\t" . '<url>' . "\n" .
            "\t\t" . '<loc>' . get_permalink( $post->ID ) . '</loc>' .
            "\n\t\t" . '<lastmod>' . $postdate[0] . '</lastmod>' .
            "\n\t\t" . '<changefreq>weekly</changefreq>' .
            "\n\t" . '</url>' . "\n";
    }
    $sitemap .= '</urlset>';
    $fp = fopen( ABSPATH . "sitemap.xml", 'w' );
    fwrite( $fp, $sitemap );
    fclose( $fp );
}

/**
 * @return mixed
 */
function xwp_Get_Post_Schema_Street_Address()
{

    //get website title
    $title = get_bloginfo('name');

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;


    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 2";


    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);


    $streetAddress = $row[1]->streetAddress;

    return $streetAddress;

}

/**
 * @return mixed
 */
function xwp_Get_Post_Schema_City()
{

    //get website title
    $title = get_bloginfo('name');

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;


    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 2";


    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);

    $addressLocality = $row[1]->addressLocality;

    //var_dump($addressLocality);

    return $addressLocality;

}

function xwp_Get_Post_Schema_State()
{

    //get website title
    $title = get_bloginfo('name');

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;


    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 2";


    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);

    $addressRegion = $row[1]->addressRegion;

    //var_dump($addressLocality);

    return $addressRegion;

}

function xwp_Get_Post_Schema_PostCode()
{

    //get website title
    $title = get_bloginfo('name');

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;


    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 2";


    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);

    $postCode = $row[1]->postalCode;

    //var_dump($addressLocality);

    return $postCode;

}

function xwp_Get_Post_Schema_PhoneNumber()
{

    //get website title
    $title = get_bloginfo('name');

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;


    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 2";


    $results = $wpdb->get_row($select);

	for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);

    $phoneNumber = $row[1]->telephone;

    //var_dump($addressLocality);

    return $phoneNumber;

}

function xwp_Get_Post_Schema_Email()
{

    //get website title
    $title = get_bloginfo('name');

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;


    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 2";


    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);

    $email = $row[1]->email;

    //var_dump($addressLocality);

    return $email;

}

function xwp_Get_Post_Schema_Description()
{

    //get website title
    $title = get_bloginfo('name');

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;


    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 2";


    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);

    $description = $row[1]->description;

    //var_dump($addressLocality);

    return $description;

}

function xwp_Get_Post_Schema_Brands()
{

    //get website title
    $title = get_bloginfo('name');

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;


    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 2";


    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);

    $brands = $row[1]->brands;

    //var_dump($addressLocality);

    return $brands;

}

function xwp_Get_Page_Schema_Street_Address()
{

    //get website title
    $title = get_bloginfo('name');

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;


    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 1";


    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);


    $streetAddress = $row[1]->streetAddress;

    return $streetAddress;

}

/**
 * @return mixed
 */
function xwp_Get_Page_Schema_City()
{

    //get website title
    $title = get_bloginfo('name');

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;


    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 1";


    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);

    $addressLocality = $row[1]->addressLocality;

    //var_dump($addressLocality);

    return $addressLocality;

}

function xwp_Get_Page_Schema_State()
{

    //get website title
    $title = get_bloginfo('name');

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;


    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 1";


    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);

    $addressRegion = $row[1]->addressRegion;

    //var_dump($addressLocality);

    return $addressRegion;

}

function xwp_Get_Page_Schema_PostCode()
{

    //get website title
    $title = get_bloginfo('name');

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;


    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 1";


    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);

    $postCode = $row[1]->postalCode;

    //var_dump($addressLocality);

    return $postCode;

}

function xwp_Get_Page_Schema_PhoneNumber()
{

    //get website title
    $title = get_bloginfo('name');

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;


    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 1";


    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);

    $phoneNumber = $row[1]->telephone;

    //var_dump($addressLocality);

    return $phoneNumber;

}

function xwp_Get_Page_Schema_Email()
{

    //get website title
    $title = get_bloginfo('name');

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;


    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 1";


    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);

    $email = $row[1]->email;

    //var_dump($addressLocality);

    return $email;

}
function xwp_Get_Page_Schema_Image()
{

    $row = [];
    $post = [];



    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 1";


    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);

    $description = $row[1]->image;

    //var_dump($addressLocality);

    return $description;

}
function xwp_Get_Page_Schema_Description()
{

    $row = [];
    $post = [];



    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 1";


    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);

    $description = $row[1]->description;

    //var_dump($addressLocality);

    return $description;

}

function xwp_Get_Page_Schema_Brands()
{

    //get website title
    $title = get_bloginfo('name');

//get logo address
//    $args = array(
//        'post_type' => 'attachment',
//        'post_mime_type' => 'image',
//        'post_parent' => $post->ID
//    );
//    $images = get_posts($args);
//
//    $logo = array();
//    foreach ($images as $image):
//
//        $logo[] = wp_get_attachment_url($image->ID, '', '', '', '');
//
//    endforeach;


    include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');

    global $wpdb;
    $table_name = $wpdb->prefix . "schemaLocalBusiness";

    $select = "SELECT * FROM `" . $table_name . "` WHERE id = 1";


    $results = $wpdb->get_row($select);

    for ($x = 1; $x <= sizeof($results); $x++) {
        $row[$x] = $results;
        //print_r($row);
    }

    //print_r($row);

    $brands = $row[1]->brands;

    //var_dump($addressLocality);

    return $brands;

}