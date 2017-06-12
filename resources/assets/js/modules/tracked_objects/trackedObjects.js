/*====================================================*/
// trackedObjects CRUD
/*====================================================*/

$(function (){
    // $(document).delegate('.removeTrackedObject', 'click', function () {
    //     var element = $(this);
    //     element.addClass('disabled');
    //     var row = element.parents('tr').first();
    //     var url = element.data('href');
    //     requester.delete(url, {}, {}).then(function (success) {
    //         row.replaceWith(success.html)
    //     }, function (error) {
    //         console.log(error);
    //     });
    // });
    //
    // $(document).delegate('.restoreTrackedObjectButton', 'click', function () {
    //     var element = $(this);
    //     element.addClass('disabled');
    //     var row = element.parents('tr').first();
    //     var url = element.data('href');
    //     requester.get(url, {}).then(function (success) {
    //         row.replaceWith(success.html)
    //     }, function (error) {
    //         console.log(error);
    //     });
    // });
    //
    // /*
    //  * CREATE
    //  */
    //
    // $(document).delegate('.createTrackedObject', 'click', function () {
    //     var element = $(this);
    //     if (element.hasClass('disabled')) {
    //         return;
    //     }
    //
    //     element.addClass('disabled');
    //     showModal();
    //     var action = element.data('href');
    //     requester.get(action).then(function (success) {
    //         setModalHtml(success.html);
    //         element.removeClass('disabled');
    //     }, function (error) {
    //         console.log(error);
    //     });
    // });
    //
    // $(document).delegate('#createTrackedObjectForm', 'submit', function () {
    //     var form = $(this);
    //     var data = form.serialize()
    //     var action = form.attr('action');
    //     requester.post(action, null, data).then(function (success) {
    //         var html = $(success.html);
    //         $('#trackedObjectsTable tr:last').after(html);
    //         closeModal();
    //         ScrollToElement('#' + html.attr('id'), 1000);
    //     }, function (error) {
    //
    //     });
    //     return false;
    // });

    $(document).delegate('select[name="tracked_object_brand_id"]', 'change', function () {
        var element = $(this);
        var brandId = element.val();
        requester.get('/trackedobjects/ajax/brand/get_models/' + brandId).then(function (data) {
            $('#models_holder').html(data.html).fadeIn(100);
        }, function (error) {
            console.log(error);
        });
    });

    /*
     * UPDATE
     */
    // $(document).delegate('.editTrackedObject', 'click', function () {
    //     var element = $(this);
    //     if (element.hasClass('disabled')) {
    //         return;
    //     }
    //     element.addClass('disabled');
    //     showModal();
    //     var action = element.data('href');
    //     requester.get(action).then(function (success) {
    //         setModalHtml(success.html);
    //         element.removeClass('disabled');
    //     }, function (error) {
    //
    //     });
    // });
    //
    // $(document).delegate('#updateTrackedObjectForm', 'submit', function () {
    //     var form = $(this);
    //     var data = form.serialize();
    //     var action = form.attr('action');
    //     form.find('button[type="submit"]').addClass('disabled');
    //     requester.put(action, null, data).then(function (success) {
    //         $('#' + $(success.html).attr('id')).replaceWith(success.html);
    //         closeModal();
    //     }, function (error) {
    //         form.find('button[type="submit"]').removeClass('disabled');
    //         console.log(error);
    //     });
    //     return false;
    // });
});
