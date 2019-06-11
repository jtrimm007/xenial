<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



//	$_SESSION['keywords'] = $_POST['keywords'];

//	$keywords = $_SESSION['keywords'];

if(isset($_POST['addressLocality']))
{
	/*
*Location session variables
*/

	$_SESSION['addressLocality'] = $_POST['addressLocality'];

	$_SESSION['addressRegion'] = $_POST['addressRegion'];

	$_SESSION['postalCode'] = $_POST['postalCode'];

	$_SESSION['streetAddress'] = $_POST['streetAddress'];


	$_SESSION['pages'] = $_POST['pages'];

	$_SESSION['paymentAccepted'] = $_POST['paymentAccepted'];

//	$_SESSION['latitude'] = $_POST['latitude'];
//	$_SESSION['longitude'] = $_POST['longitude'];

	/*
	*Contact information session and variables
	*/

	$_SESSION['telephone'] = $_POST['telephone'];
	$_SESSION['email'] = $_POST['email'];


	/*
	*Hour sessions and variables
	*/

// Monday
	$_SESSION['MondayOpen'] = $_POST['MondayOpen'];
	$mondayOpen = $_SESSION['MondayOpen'];

	$_SESSION['MondayClose'] = $_POST['MondayClose'];
	$mondayClose = $_SESSION['MondayClose'];

//Tuesday
	$_SESSION['TuesdayOpen'] = $_POST['TuesdayOpen'];
	$tuesdayOpen = $_SESSION['TuesdayOpen'];

	$_SESSION['TuesdayClose'] = $_POST['TuesdayClose'];
	$tuesdayClose = $_SESSION['TuesdayClose'];

//Wednesday
	$_SESSION['WednesdayOpen'] = $_POST['WednesdayOpen'];
	$wednesdayOpen = $_SESSION['WednesdayOpen'];

	$_SESSION['WednesdayClose'] = $_POST['WednesdayClose'];
	$wednesdayClose = $_SESSION['WednesdayClose'];

//Thursday
	$_SESSION['ThursdayOpen'] = $_POST['ThursdayOpen'];
	$thursdayOpen = $_SESSION['ThursdayOpen'];

	$_SESSION['ThursdayClose'] = $_POST['ThursdayClose'];
	$thursdayClose = $_SESSION['ThursdayClose'];

//Friday
	$_SESSION['FridayOpen'] = $_POST['FridayOpen'];
	$fridayOpen = $_SESSION['FridayOpen'];

	$_SESSION['FridayClose'] = $_POST['FridayClose'];
	$fridayClose = $_SESSION['FridayClose'];

//Saturday
	$_SESSION['SaturdayOpen'] = $_POST['SaturdayOpen'];
	$saturdayOpen = $_SESSION['SaturdayOpen'];

	$_SESSION['SaturdayClose'] = $_POST['SaturdayClose'];
	$saturdayClose = $_SESSION['SaturdayClose'];

//Sunday
	$_SESSION['SundayOpen'] = $_POST['SundayOpen'];
	$sundayOpen = $_SESSION['SundayOpen'];

	$_SESSION['SundayClose'] = $_POST['SundayClose'];
	$sundayClose = $_SESSION['SundayClose'];


	/*
	*Price Range Session and Variables
	*/

	$_SESSION['priceRange'] = $_POST['priceRange'];

	/*
	*Brands carried session
	*/

	$_SESSION['brands'] = $_POST['brands'];

	/*
	*About section session and variables
	*/

	$_SESSION['description'] = $_POST['description'];

	$_SESSION['image'] = $_POST['image'];



}
