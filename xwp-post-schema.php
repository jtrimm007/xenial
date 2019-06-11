<?php

if (!current_user_can('administrator')) {
    echo '<h3>Admin access is required</h3>';
} else {
    include_once('sessions.php');
    include_once('xenial-WP.php');

    ?>
    <div class="SchemaHead">
        <h1 class="SchemaH1">Xenial Schema</h1>
        <h3>For Posts</h3>
        <p>by:</p>

        <div id="logoBackground">

            <a href="https://trimwebdesign.com" target="_blank"><img id="myLogo" src="https://trimwebdesign.com/wp-content/uploads/2017/09/Trim-web-design-nav-logo.png"></a>
        </div>
        <p>A full service WordPress website design & SEO company.</p>
    </div>
    <?php

//database query
    xwp_selectAllFromDatabase();


    xwp_paymentAccepted();





    if (isset($_SESSION['streetAddress'])) {
        xwp_insertPostSchema();
    }


    ?>


    <!-- Start Form -->

    <form method="post" action="<?php $_SERVER['REQUEST_URI']; ?>">
        <h3>Schema Local Business</h3>
        <p>Phyiscal Address</p>


        <!-- address -->


        <input name="streetAddress" placeholder="<?php echo xwp_Get_Post_Schema_Street_Address(); ?>" value="<?php echo xwp_Get_Post_Schema_Street_Address(); ?>">
        <input name="addressLocality" placeholder="<?php echo xwp_Get_Post_Schema_City(); ?>" type="text" value="<?php echo xwp_Get_Post_Schema_City(); ?>">
        <input name="addressRegion" placeholder="State" type="text" value="<?php echo xwp_Get_Post_Schema_State(); ?>">
        <input name="postalCode" placeholder="Postal Code" type="text" value="<?php echo xwp_Get_Post_Schema_PostCode(); ?>">
        <hr>

        <!-- geo coordinates -->
        <!--
        <h3>Geo Cordinates</h3>


        <input name="latitude" placeholder="Latitude">
        <input name="longitude" placeholder="longitude">
        -->
        <!-- Contact Information -->

        <h3>Phone</h3>
        <input name="telephone" placeholder="Phone Number" value="<?php echo xwp_Get_Post_Schema_PhoneNumber(); ?>">

        <!-- email -->

        <h3>Email</h3>
        <input name="email" placeholder="email" value="<?php echo xwp_Get_Post_Schema_Email(); ?>">

        <!-- hours -->
        <hr>
        <h3>Business Hours</h3>

        <strong>Monday</strong><br>
        opening
        <select name="MondayOpen">
            <?php esc_html(xwp_openTime()); ?>
        </select>
        closing
        <select name="MondayClose">
            <?php esc_html(xwp_closeTime()); ?>
        </select>
        <br>
        <strong>Tuesday</strong><br>
        opening
        <select name="TuesdayOpen">
            <?php esc_html(xwp_openTime()); ?>
        </select>
        closing
        <select name="TuesdayClose">
            <?php esc_html(xwp_closeTime()); ?>
        </select>
        <br>
        <strong>Wednesday</strong><br>
        opening
        <select name="WednesdayOpen">
            <?php esc_html(xwp_openTime()); ?>
        </select>
        closing
        <select name="WednesdayClose">
            <?php esc_html(xwp_closeTime()); ?>
        </select>
        <br>
        <strong>Thursday</strong><br>
        opening
        <select name="ThursdayOpen">
            <?php esc_html(xwp_openTime()); ?>
        </select>
        closing
        <select name="ThursdayClose">
            <?php esc_html(xwp_closeTime()); ?>
        </select>
        <br>
        <strong>Friday</strong><br>
        opening
        <select name="FridayOpen">
            <?php esc_html(xwp_openTime()); ?>
        </select>
        closing
        <select name="FridayClose">
            <?php esc_html(xwp_closeTime()); ?>
        </select>
        <br>
        <strong>Saturday</strong><br>
        opening
        <select name="SaturdayOpen">
            <?php esc_html(xwp_openTime()); ?>
        </select>
        closing
        <select name="SaturdayClose">
            <?php esc_html(xwp_closeTime()); ?>
        </select>
        <br>
        <strong>Sunday</strong><br>
        opening
        <select name="SundayOpen">
            <?php esc_html(xwp_openTime()); ?>
        </select>
        closing
        <select name="SundayClose">
            <?php esc_html(xwp_closeTime()); ?>
        </select>
        <hr>
        <br>

        <!-- select pages for output -->

        <?php esc_html(xwp_selectPosts()); ?>
        <hr>

        <!-- Payment types -->

        <h3>Payment Type</h3>

        <input type="checkbox" name="checkAllPayment" onclick="selectAllPayment(this)"><strong>Check All</strong>
        <br>
        <input type="checkbox" name="paymentAccepted[]" value="cash">Cash
        <br>
        <input type="checkbox" name="paymentAccepted[]" value="check">Check
        <br>
        <input type="checkbox" name="paymentAccepted[]" value="visa">Visa
        <br>
        <input type="checkbox" name="paymentAccepted[]" value="mastercard">MasterCard
        <br>
        <input type="checkbox" name="paymentAccepted[]" value="AMX">AMX
        <br>
        <input type="checkbox" name="paymentAccepted[]" value="discover">Discover
        <br>
        <input type="checkbox" name="paymentAccepted[]" value="bitcoin">Bitcoin
        <br>
        <input type="checkbox" name="paymentAccepted[]" value="paypal">PayPal

        <!-- Price Range section -->

        <h3>Price Range</h3>

        <input type="radio" name="priceRange" value="$">$ <br>
        <input type="radio" name="priceRange" value="$$">$$ <br>
        <input type="radio" name="priceRange" value="$$$">$$$ <br>
        <input type="radio" name="priceRange" value="$$$$">$$$$
        <hr>

        <!-- brands carried -->

        <h3>Brands Carried</h3>

        <textarea name="brands" rows="10" cols="30" placeholder="Comma after each brand."><?php echo xwp_Get_Post_Schema_Brands(); ?></textarea>
        <hr>

        <!-- About Section -->

        <h3>About</h3>
        <textarea name="description" rows="10" cols="30"
                  placeholder="Tell search engines a little about your business."><?php echo xwp_Get_Post_Schema_Description(); ?></textarea>
        <hr>
        <h3>Insert Logo</h3>
        <input name="image" value="<?php echo xwp_Get_Page_Schema_Image(); ?>" placeholder="Copy the url of your website logo and paste it here." required><br>

        <input type="submit" value="submit">
    </form>


    <h3>Results</h3>
    <p>The results displayed below are what will display for structured data on the frontend of the pages selected.</p>
    <?php xwp_json_Post_schema();?>
    <p>Please check your results with Googles <a
            href="https://search.google.com/structured-data/testing-tool/u/0/#url=<?php echo $_SERVER['SERVER_NAME']; ?>"
            target="_blank">Structured Data Testing Tool</a>.</p>


    <?php
}
?>
