jQuery(document).ready(function () {

    jQuery("#owl-demo").owlCarousel({

        navigation: false, // Show next and prev buttons
        slideSpeed: 2000,
        paginationSpeed: 2000,
        rewindSpeed: 2000,
        pagination: false,
        singleItem: true,
        autoPlay: 10000
    });

    jQuery("a").on('click', function(event) {

        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            jQuery('html, body').animate({
                scrollTop: jQuery(hash).offset().top
            }, 1500, function(){

                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });
        }
    });
});