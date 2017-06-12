window.onload = function () {

    $('[data-toggle="tooltip"]').tooltip();

    $(document).delegate('select[name="tracked_object_brand_id"]', 'change', function () {
        var element = $(this);
        var brandId = element.val();
        requester.get('/trackedobjects/ajax/brand/get_models/' + brandId).then(function (data) {
            $('#models_holder').html(data.html).fadeIn(100);
        }, function (error) {
            console.log(error);
        });
    });

    // Update tab:groups -> tracked objects column
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
            $.each(response.groups, function (i, groupTrackedObjects) {
                var row = $('#groups_table').dataTable().api().row('#'+i).node();

                $('#groups_table').dataTable().api()
                    .cell(row, 2)
                    .data(groupTrackedObjects);
            });
        }
    }

    $(document).delegate('.remove_input', 'click', function (ev) {
        $(this).closest('.inputwidg').remove();
    });

    $(document).delegate('.destroy_input', 'click', function (ev) {
        requester.delete($(this).data('destroy'), null, '').then(
            function (success) {
                $('.inputswidget').html(subootrccess.html)
                $('.validation_errors').html('');
            },
            function (fail) {

            }
        );
    });

    $(document).delegate('.restore_input', 'click', function (ev) {
        var thisInput = $(this);
        requester.post($(this).data('restore'), null, '').then(
            function (success) {
                $('.inputswidget').html(success.html)
            },
            function (fail) {

            }
        );
    });

    var hideNonMandatoryTranslationFields = function () {
        if ($('#input_type').html() != 'digital') {
            $.each($('.digital_on'), function () {
                $(this).closest('.form-group').first().addClass('digital').hide();
            });
            $.each($('.digital_off'), function () {
                $(this).closest('.form-group').first().addClass('digital').hide();
            });
        }
    }
    $(document).delegate('.btn', 'click', function (ev) {
        if ($(this).hasClass('manage_inputs')) {
            $('#baseModal').find('.modal-dialog').addClass('modal-lg');

        } else {
            $('#baseModal').find('.modal-dialog').removeClass('modal-lg');
        }
        // setTimeout(function() {
        //     hideNonMandatoryTranslationFields();
        // }, 1000);
    });

    $(document).delegate('.manage_inputs.edit_input, .manage_inputs.add_input', 'click', function(e) {
        requester.get($(this).data('get'), null, null).then(
            function (success) {
                $('.validation_errors').html('');
                $('.inputwidget').html(success.html);
                hideNonMandatoryTranslationFields();
                $('#input_type').trigger('change')
            },
            function (fail) {

            }
        );
    });

    $(document).delegate('#postinput', 'submit', function (event) {
        event.preventDefault();
        requester.post($(this).attr('action'), null, $(this).serialize()).then(
            function (success) {
                // console.log([$('.inputswidget').length, success]);
                $('.inputswidget').html(success.html)
                $('.validation_errors').html('');
            },
            function (fail) {
                parseErrors(fail);
            }
        );
    });

    $(document).delegate('.postinput', 'click', function (event) {
        // var inputForm = $(this).closest('form');
        // console.log('waaaat!?!?!');return false;
        // requester.post(inputForm.attr('action'), null, inputForm.serialize()).then(
        //     function (success) {
        //         // console.log([$('.inputswidget').length, success]);
        //         $('.inputswidget').html(success.html)
        //     },
        //     function (fail) {
        //         parseErrors(fail);
        //     }
        // );
    });

    $(document).delegate('#input_type', 'change', function (ev) {
        $('#postinput').children('input').show();
        $('#postinput').children('select').show();

        var inputType = $(this).children('option:selected').text();

        switch(inputType) {
            case 'digital':
                $('.analog').hide();
                $('.one_wire').hide();
                // $('input.analog, input.one_wire, select.analog, select.one_wire').hide();
                $('.digital').show();
                break;
            case '1wire':
                $('.analog').hide();
                $('.digital').hide();
                $('.one_wire').show();
                break;
            case 'analog':
                $('.digital').hide();
                $('.one_wire').hide();
                $('.analog').show();
            default: return;
        }
    });

    $(document).on('modal_form_loaded', function (ev) {
        setTimeout(function(){
            $('#input_type').trigger('change')
        }, 300);
    });

    var parseErrors = function (errors) {
    // Remove error class from input fields
    $('.form-control').removeClass('error');

    $('.validation_errors').html('');

    // Create alert with error messages
    var div = $(document.createElement('div'));
    div.addClass('alert alert-danger alert-dismissable');
    div.html('<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>');

    // Loop errors
    $.each(errors.responseJSON, function (key, value) {
        // Replace names of the fields which are named with array format (.1 with [1]). Example: first_name.1 to first_name[1]
        if (key.indexOf('.') !== -1) {
            key = key.split('.').join('][');
            key = key.replace(/\./g, '][');
            key = key.replace(']', '');
            key += ']';
        }

        // Add error class to fields with mistake
        $("input[name='" + key + "'], select[name='" + key + "'], textarea[name='" + key + "']").addClass('error');
        // Add error to alert
        div.append('<div class="text-left">' + value + '</div>');
    });

    $('.validation_errors').append(div);
}

};
