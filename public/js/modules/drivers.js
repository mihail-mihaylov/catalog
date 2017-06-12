// window.onload = function () {
//
//     /*
//      * CREATE
//      */
//
//     $(document).delegate('.createDriver', 'click', function () {
//         var element = $(this);
//         if (element.hasClass('disabled')) {
//             return;
//         }
//         element.addClass('disabled');
//         showModal();
//         var action = element.data('href');
//         requester.get(action).then(function (success) {
//             setModalHtml(success.html);
//             element.removeClass('disabled');
//         }, function (error) {
//             console.log(error);
//         });
//     });
//
//     $(document).delegate('#createDriverForm', 'submit', function () {
//         var form = $(this);
//         var data = form.serialize()
//         var action = form.attr('action');
//         requester.post(action, null, data).then(function (success) {
//             var html = $(success.html);
//             $('#driversTable tr:last').after(html);
//             closeModal();
//             ScrollToElement('#' + html.attr('id'), 1000);
//         }, function (error) {
//
//         });
//
//         return false;
//     });
//
//     /*
//      * DELETE
//      */
//
//     $(document).delegate('.deleteDriver', 'click', function () {
//         var element = $(this);
//
//         if (element.hasClass('disabled')) {
//             return;
//         }
//         element.addClass('disabled');
//
//         var action = element.data('action');
//         requester.delete(action, {}, {}).then(function (success) {
//             element.parents('tr').first().replaceWith(success.html);
//         }, function (error) {
//             console.log(error);
//         });
//     });
//
//     /*
//      * RESTORE
//      */
//
//     $(document).delegate('.restoreDriver', 'click', function () {
//         var element = $(this);
//
//         if (element.hasClass('disabled')) {
//             return;
//         }
//
//         element.addClass('disabled');
//
//         var action = element.data('action');
//         requester.post(action, {}, {}).then(function (success) {
//             element.parents('tr').first().replaceWith(success.html);
//         }, function (error) {
//             console.log(error);
//         });
//     });
//
//     /*
//      * UPDATE
//      */
//     $(document).delegate('.editDriver', 'click', function () {
//         var element = $(this);
//         if (element.hasClass('disabled')) {
//             return;
//         }
//         element.addClass('disabled');
//         showModal();
//         var action = element.data('action');
//         requester.get(action).then(function (success) {
//             setModalHtml(success.html);
//             element.removeClass('disabled');
//         }, function (error) {
//
//         });
//     });
//
//     $(document).delegate('#updateDriverForm', 'submit', function () {
//         var form = $(this);
//         var data = form.serialize();
//         var driverId = form.data('driver-id');
//         var action = form.attr('action');
//         form.find('button[type="submit"]').addClass('disabled');
//         requester.put(action, null, data).then(function (success) {
//             $('#driverRow' + driverId).replaceWith(success.html);
//             closeModal();
//         }, function (error) {
//             form.find('button[type="submit"]').removeClass('disabled');
//             console.log(error);
//         });
//         return false;
//     });
//
// };
//# sourceMappingURL=drivers.js.map
