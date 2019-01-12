jQuery(window).scroll(function() {

    var j = jQuery.noConflict();

    var url = window.location.href;

    if(j(window).scrollTop() == j(document).height() - j(window).height()) {
        // ajax call get data from server and append to the div
        j.get(url, function(data) {
            j('div').each().append(data);
            //j('img').each().append(data);

        });
    }
});