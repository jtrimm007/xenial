<div class="SchemaHead">
    <h1 class="SchemaH1">Xenial Information</h1><p>by:</p>

    <div id="logoBackground">

        <a href="https://trimwebdesign.com" target="_blank"><img id="myLogo" src="https://trimwebdesign.com/wp-content/uploads/2017/09/Trim-web-design-nav-logo.png"></a>
    </div>
    <p>A full service WordPress website design & SEO company.</p>
</div>


<?php


if (!current_user_can("administrator")) {
    echo '<h3>Admin access is required</h3>';
} else {

        include_once('sessions.php');

    include_once('xenial-WP.php');
}
?>

<!-- Tab links -->
<div class="tab">
    <button class="tablinks active" onclick="openCity(event, 'About')">About</button>
    <button class="tablinks" onclick="openCity(event, 'Donate')">Donate</button>
    <button class="tablinks" onclick="openCity(event, 'sitemap')">Sitemaps</button>
    <button class="tablinks" onclick="openCity(event, 'bug')">Report a Bug</button>

</div>

<!-- Tab content -->
<div id="About" class="tabcontent">
    <h3>About</h3>
    <p>Xenial is a product of Trim Web Design & SEO. Built to help small businesses
        improve search rankings.</p>


    <h2>Future</h2>
    <p>Xenial will have a premium version that will let users expound on the type of
        schema they would like to implement, per page/post.</p>
</div>

<div id="Donate" class="tabcontent">
    <h3>Donate</h3>
    <p>If you would like to help keep Xenial going, please donate via paypal to jbthype@gmail.com.</p>
</div>

<div id="sitemap" class="tabcontent">
    <h3>SiteMaps</h3>
    <p>Please copy these urls and place them in your google search console.</p>


    <a href="/sitemap.xml" target="_blank">sitemap.xml</a>
    <br>
    <a href="https://search.google.com/search-console?utm_source=about-page" target="_blank">Google Search Console</a>

</div>

<div id="bug" class="tabcontent">
    <h2>Report a bug</h2>
    <p>Please email: joshua@trimwebdesign.com</p>
</div>

