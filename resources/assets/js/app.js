
/**
 * First we will load all of this project's JavaScript dependencies.
 */
require('vegas');
// require('./infinite-scroll');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/* ---- Main JS Scrips ---- */

$(document).foundation();

/** /
(function ($) {
    var socialVisitCount = 0,
        socialVisitRule = 2;

    $('.upload-rules a').on('click', function(){
        socialVisitCount++;

        if (socialVisitCount >= socialVisitRule) {
            $('#upload-login').prop('disabled', false);
        }
    });
})(jQuery);
/**/

/* Infinite Scroll */
var infiniteContainer = $('.infinite-container');

infiniteContainer.infiniteScroll({
    path: '.invinite-btn',
    append: '.infinite-item',
    history: false,
    button: '.invinite-btn',
    checkLastPage: '.invinite-btn',
    scrollThreshold: false
});

infiniteContainer.on( 'load.infiniteScroll', function( event, response, path ) {
    var nextPage = $(response).find('.invinite-btn').attr('href');

    if (nextPage) {
        $('.invinite-btn').attr('href', nextPage);
    }
});
/* End Infinite Scroll */

/* Image Input File */
$('.resep-img-field').on('change', function(){
    $('.resep-img').css('background-image', 'url('+window.URL.createObjectURL(this.files[0])+')');
});
/* End Image Input File */

/* User Nav */
$('#user-navigation').on('change', function(){
    window.location.href = $(this).val();
});