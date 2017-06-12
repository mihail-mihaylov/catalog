
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
window.onload = function ()
{
    // Update tab:groups -> users column
    $(document)
        .on('modal_form_submited', function(e, response) {
            updateGroups(response);
        })
        .on('update_entity', function(e, response) {
            updateGroups(response);
        })
        .on('delete_entity', function(e, response) {
           updateGroups(response);
        });

    function updateGroups(response) {
        if (response.groups) {
            $.each(response.groups, function (i, groupUsers) {
                var row = $('#groups_table').dataTable().api().row('#group_'+i).node();

                $('#groups_table').dataTable().api()
                    .cell(row, 2)
                    .data(groupUsers);
            });
        }
    }
};

// ============ OLD STUFF ============
//     /**
//      * Get create user form
//      */
//     $(document).delegate('.create_user', 'click', function () {
//         var element = $(this);
//         if (element.hasClass('disabled')) {
//             return;
//         }
//         element.addClass('disabled');
//         showModal(element.data('title'));
//         console.log('gosho');
//         var action = element.data('action');
//         requester.get(action).then(function (success) {
//             setModalHtml(success.html);
//             element.removeClass('disabled');
//         }, function (error) {
//             console.log(error);
//         });
//     });
//
//     /**
//      * Post create user form
//      */
//     $(document).delegate('.post_user', 'submit', function (event) {
//         var form = $(this);
//         var data = form.serialize()
//         var action = form.attr('action');
//
//         showUserSpinner();
//         requester.post(action, null, data).then(function (success) {
//             var row = $(success.row);
//             $('#user_panel tr:last').after(row);
//             closeModal();
//             ScrollToElement('#' + row.attr('id'), 1000);
//         }, function (error) {
//             appendErrorsToModal(error.responseJSON)
//             hideUserSpinner();
//         });
//
//         return false;
//     });
//
//     /**
//      * Get edit user form
//      */
//     $(document).delegate('.edit_user', 'click', function(event) {
//         var element = $(this);
//         if (element.hasClass('disabled')) {
//             return;
//         }
//         element.addClass('disabled');
//         showModal(element.data('title'));
//         var action = element.data('action');
//
//         requester.get(action).then(function (success) {
//             setModalHtml(success.html);
//             element.removeClass('disabled');
//         }, function (error) {
//             console.log(error);
//         });
//     });
//
//     /**
//      * Post edit user form
//      */
//     $(document).delegate('.put_user', 'submit', function(event) {
//         var form = $(this);
//         var data = form.serialize();
//         var action = form.attr('action');
//         form.find('button[type="submit"]').addClass('disabled');
//
//         showUserSpinner();
//         requester.put(action, null, data).then(function (success) {
//             $('#' + $(success.html).attr('id')).replaceWith(success.html);
//             closeModal();
//         }, function (error) {
//             form.find('button[type="submit"]').removeClass('disabled');
//             appendErrorsToModal(error.responseJSON)
//             hideUserSpinner();
//         });
//
//         return false;
//     });
//
//
//     /**
//      * Delete user
//      */
//     $(document).delegate('.delete_user', 'submit', function (event) {
//         var element = $(this);
//
//         event.preventDefault();
//         element.attr('disabled', 'disabled');
//         var formAction = element.attr('action');
//         var parentRow = element.parents('tr').first();
//
//         requester.delete(formAction, null, $(this).serialize()).then(
//             function (success) {
//                 parentRow.replaceWith(success.row);
//             },
//             function (error) {
//                 console.log(error);
//             }
//         );
//
//         return false;
//     });
//
//     /**
//      * Restore user
//      */
//     $(document).delegate('.restore_user', 'click', function(event) {
//         var element = $(this);
//
//         event.preventDefault();
//         var parentRow = element.parents('tr').first();
//         element.attr('disabled', 'disabled');
//
//         requester.get(element.attr('href')).then(
//             function (success) {
//                 parentRow.replaceWith(success.row);
//             },
//             function (error) {
//                 console.log(error);
//             }
//         );
//     });
//
//     var showUserSpinner = function () {
//         $('#submit_user_spinner').removeClass('hidden');
//     }
//
//     var hideUserSpinner = function () {
//         $('#submit_user_spinner').addClass('hidden');
//     }

//# sourceMappingURL=users.js.map
