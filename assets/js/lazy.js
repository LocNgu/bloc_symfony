$(document).ready(function() {
    $('body').prepend('<h1>lazyloading</h1>');
});

$('.lazy').show().Lazy();

$('.lazy').Lazy({
// your configuration goes here
    scrollDirection: 'vertical',
    effect: "fadeIn",
    visibleOnly: true,
    onError: function(element) {
        console.log('error loading ' + element.data('src'));
    }
});