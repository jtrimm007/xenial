<?php
/**
 * Created by PhpStorm.
 * User: Joshua
 * Date: 9/7/2018
 * Time: 3:11 PM
 */

if (!current_user_can('administrator')) {
    echo '<h3>Admin access is required</h3>';
} else {
    include_once('sessions.php');
    include_once('xenial-WP.php');

    ?>
    <div class="SchemaHead">
        <h1 class="SchemaH1">Robots.txt File Creation</h1>
        <p>by:</p>

        <div id="logoBackground">

            <a href="https://trimwebdesign.com" target="_blank"><img id="myLogo" src="https://trimwebdesign.com/wp-content/uploads/2017/09/Trim-web-design-nav-logo.png"></a>
        </div>
        <p>A full service WordPress website design & SEO company.</p>
    </div>
    <br>
    <p><strong>Once this page has loaded successfully, the robots.txt file has been created successfully.</strong></p>

    <?php    xwp_custom_robots_dot_txt();
}
?>
