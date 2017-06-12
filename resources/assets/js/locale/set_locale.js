$(document).delegate('.set_locale', 'click', function (ev) {
var requester = app.requester.load();
    var code = $(this).data('code');
    requester.get('/setLocale/' + code).then(
        function (success) {
            // console.log(success);
            location.reload();
        },
        function (fail) {
            console.log(fail)
        }
    )

});
