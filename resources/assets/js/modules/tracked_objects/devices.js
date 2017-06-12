// /*====================================================*/
// // Devices CRUD
// /*====================================================*/
//
//
// window.onload = function () {
//
//     /*
//      * CREATE DEVICE
//      */
//
//     $(document).delegate('.createNewDevice', 'click', function () {
//         var element = $(this);
//         var action = element.data('href');
//         element.addClass('disabled');
//         showModal();
//         requester.get(action, null).then(function (success) {
//             setModalHtml(success.html);
//             element.removeClass('disabled');
//         }, function (error) {
//             console.log(error);
//         });
//     });
//
//     $(document).delegate('#createNewDeviceForm', 'submit', function () {
//         var form = $(this);
//         var data = form.serialize();
//         var action = form.attr('action');
//         form.find('button[type="submit"]').addClass('disabled');
//         requester.post(action, null, data).then(function (success) {
//            var html = $(success.html);
//             $('#devicesTable tr:last').after(html);
//             closeModal();
//             ScrollToElement('#' + html.attr('id'), 1000);
//         }, function (error) {
// //            form.find('button[type="submit"]').removeClass('disabled');
//             console.log(error);
//         });
//         return false;
//     });
//
//
//     /*
//      * EDIT DEVICE
//      */
//
//     $(document).delegate('.editDevice', 'click', function () {
//         var element = $(this);
//         var action = element.data('href');
//         element.addClass('disabled');
//         showModal();
//         requester.get(action, null).then(function (success) {
//             setModalHtml(success.html);
//             element.removeClass('disabled');
//         }, function (error) {
//             console.log(error);
//         });
//     });
//
//     /*
//      * DELETE DEVICE
//      */
//
//     $(document).delegate('.deleteDevice', 'click', function () {
//         var element = $(this);
//
//         if (element.hasClass('disabled')) {
//             return;
//         }
//         element.addClass('disabled');
//
//         var action = element.data('href');
//         var row = element.parents('tr').first();
//         requester.delete(action, {}, {}).then(function (success) {
//             row.replaceWith(success.html)
//         }, function (error) {
//             console.log(error);
//         });
//     });
//
//     /*
//      * RESTORE DEVICE
//      */
//
//     $(document).delegate('.restoreDevice', 'click', function () {
//
//         var element = $(this);
//
//         if (element.hasClass('disabled')) {
//             return;
//         }
//
//         element.addClass('disabled');
//
//         var action = element.data('href');
//         var row = element.parents('tr').first();
//         requester.get(action, null).then(function (success) {
//             row.replaceWith(success.html)
//         }, function (error) {
//             console.log(error);
//         });
//     });
//
//     /*
//      * UPDATE DEVICE
//      */
//
//     $(document).delegate('.updateDevice', 'click', function () {
//         var element = $(this);
//         var form = element.parent('form');
//         var action = form.attr('action');
//         var deviceId = element.data('device-id');
//         var data = {};
//         form.find('input, select').each(
//                 function (index, child) {
//                     data[child.name] = child.value;
//                 });
//
//         requester.put(action, {}, data).then(function (success) {
//             $('#device-row-' + deviceId).replaceWith(success.html);
//             closeModal();
//         }, function (error) {
//             console.log(error);
//         });
//     });
// };
