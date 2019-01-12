 jQuery( document ).ready(function(){

        //define variables
        var url = window.location.href;

        var j = jQuery.noConflict();


        // Add itemscope and itemtype to div
        j("div.et_search_outer").attr("itemscope", "").attr("itemtype", "http://schema.org/WebSite");

        // insert meta with itemprop url and content website address
        j("div.et_search_outer").attr("itemprop", "name");

        //Form tag - itemprop potentialAction itemscope itemtype schema.org SearchAction
        j("nav ul li a").attr("itemprop", "url");

        //Search input - itemprop query input name search_term_string

    });

 jQuery( document ).ready(function(){

     // Put itemscope and itemtype into navigation ul
     jQuery("nav ul").attr("itemscope", "").attr("itemtype", "http://www.schema.org/SiteNavigationElement");
     // put itemprop in lis
     jQuery("nav ul li").attr("itemprop", "name");
     //put itemprop url in anchors
     jQuery("nav ul li a").attr("itemprop", "url");

 });
