// /**
//  * Get create group form
//  */
// $(document).delegate('.add_group', 'click', function (event) {
//     var element = $(this);
//     if (element.hasClass('disabled')) {
//         return;
//     }
//     element.addClass('disabled');
//     showModal(element.data('title'));
//     var action = element.data('action');
//     requester.get(action).then(function (success) {
//         setModalHtml(success.html);
//         element.removeClass('disabled');
//     }, function (error) {
//         console.log(error);
//     });
// });
//
// /**
//  * Post create group form
//  */
// $(document).delegate('.post_group', 'submit', function (event) {
//     var form = $(this);
//     var data = form.serialize()
//     var action = form.attr('action');
//
//     requester.post(action, null, data).then(function (success) {
//         addRow(success.id);
//         closeModal();
//         ScrollToElement('#' + success.id, 1000);
//     }, function (error) {
//         appendErrorsToModal(error.responseJSON)
//     });
//
//     return false;
// });
//
// /**
//  * Get edit group form
//  */
// $(document).delegate('.edit_group', 'click', function (event) {
//     var element = $(this);
//     if (element.hasClass('disabled')) {
//         return;
//     }
//     element.addClass('disabled');
//     showModal(element.data('title'));
//     var action = element.data('action');
//
//     requester.get(action).then(function (success) {
//         setModalHtml(success.html);
//         element.removeClass('disabled');
//     }, function (error) {
//         console.log(error);
//     });
// });
//
// /**
//  * Post edit group form
//  */
// $(document).delegate('.put_group', 'submit', function (event) {
//     var form = $(this);
//     var data = form.serialize();
//     var action = form.attr('action');
//     form.find('button[type="submit"]').addClass('disabled');
//     var id = form.attr('id').substr(form.attr('id').lastIndexOf('_') + 1);
//
//     requester.put(action, null, data).then(function (success) {
//         refreshRow(id);z
//         closeModal();
//     }, function (error) {
//         form.find('button[type="submit"]').removeClass('disabled');
//         appendErrorsToModal(error.responseJSON)
//     });
//
//     return false;
// });
//
// /**
//  * Delete group
//  */
// $(document).delegate('.delete_group', 'submit', function (event) {
//     var element = $(this);
//
//     event.preventDefault();
//     element.attr('disabled', 'disabled');
//     var formAction = element.attr('action');
//     var id = formAction.substr(formAction.lastIndexOf('/') + 1);
//
//     requester.delete(formAction, null, $(this).serialize()).then(
//         function (success) {
//             refreshRow(id);
//         },
//         function (error) {
//             console.log(error);
//         }
//     );
//
//     return false;
// });
//
// /**
//  * Restore group
//  */
// $(document).delegate('.restore_group', 'click', function (event) {
//     var element = $(this);
//
//     event.preventDefault();
//     var anchorAction = element.attr('href');
//     var id = anchorAction.substr(anchorAction.lastIndexOf('/') + 1);
//
//     element.attr('disabled', 'disabled');
//
//     requester.get(anchorAction).then(
//         function (success) {
//             refreshRow(id);
//         },
//         function (error) {
//             console.log(error);
//         }
//     );
// });
//
// var addRow = function (id, formData) {
//     requester.get('group/row_template/' + id).then(
//         function (success) {
//             var tableContainer = $('#group_panel').find('tr').first().parents().first();
//             var newRow = $(success.row);
//             newRow.hide();
//             tableContainer.append(newRow);
//             newRow.fadeIn();
//         }
//     );
// }
//
// var refreshRow = function (id) {
//     requester.get('group/row_template/' + id).then(
//         function (success) {
//             var oldRow = $('#group_' + id);
//             oldRow.replaceWith(success.row);
//         }
//     );
// }
//
// // $(document).delegate('button[data-act="ajax"]', 'click', function (event) {
// //     var element = $(this);
// //     if (element.hasClass('disabled')) {
// //         return;
// //     }
// //     element.addClass('disabled');
// //     showModal(element.data('title'));
// //     var action = element.data('action');
// //     requester.get(action).then(function (success) {
// //         setModalHtml(success.html);
// //         element.removeClass('disabled');
// //     }, function (error) {
// //         console.log(error);
// //     });
// // });
// // $(document).delegate('form[data-act="ajax"]', 'submit', function (event) {
// //     var element = $(this);
// //     var data = element.serialize();
// //     requester.get(action).then(function (success) {
// //         setModalHtml(success.html);
// //         element.removeClass('disabled');
// //     }, function (error) {
// //         console.log(error);
// //     });
// // });