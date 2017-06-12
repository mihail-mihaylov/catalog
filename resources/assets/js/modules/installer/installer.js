window.onload = function () {
    var installerSteps = $('#installer_steps');
    installerSteps.steps({
        headerTag: "h3",
        bodyTag: "div.section",
        enableAllSteps: true
    });
    $('.wizard > .actions').hide();

    $(document).delegate('#addInput','click', function (ev) {
        var addInputButton = $('#addInput');
        // some stupid racing condition renders the disabled button instruction useless
        // if the user clicks like a madman, the integer increment goes crazy
        // like 0,1,3,4,4,4,5,7,7
        if(!addInputButton.hasClass('disabled')) {

            addInputButton.addClass('disabled');
            
            requester.get('installer/getinputinstaller/' + parseInt($('.inputwidg').length)).then(
                function (success) {
                    addInputButton.closest('.form-group').append(success.html);
                    addInputButton.removeClass('disabled');
                },//
                function (fail) {
                    console.log('fail ' . fail);
            });        
        }
    });

    $(document).delegate('.remove_input', 'click', function (ev) {
        $(this).closest('.inputwidg').remove();
    });

    $(document).delegate('.destroy_input', 'click', function (ev) {
        var thisInput = $(this);
        // $(this).siblings('.remove_input').trigger('click');return false;
        requester.delete($(this).data('destroy'), null, '').then(
            function (success) {
                $('.inputswidget').html(success.html)
                // $(this).closest('li').remove();//
                // thisInput.siblings('.remove_input').trigger('click');
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
    $(document).delegate('#installer_form', 'submit', function (ev) {
        ev.preventDefault();

        requester.post($(this).attr('action'), null, $(this).serialize()).then(
            function (success) {
                // $("#inputs").html(success.html)
                // $('.validation_errors').html('');
                // $('.form-control').removeClass('error');
            },

            function (fail) {
                parseErrorsToForm(fail);
            }
        );
    });
    $(document).delegate('#get_device_inputs_form', 'submit', function (ev) {
        ev.preventDefault();
        console.log($(this).serialize());
        requester.post($(this).attr('action'), null, $(this).serialize()).then(
            function (success) {
                $("#inputs").html(success.html)
                $('#inputs').prepend($("<div class='hr-line-dashed'></div>"));
                // $('.validation_errors').html('');
                // $('.form-control').removeClass('error');
            },

            function (fail) {
                parseErrorsToForm(fail);
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
                parseErrorsToForm(fail);
            }
        );
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
    var hideNonMandatoryTranslationFields = function () {
        if ($('#input_type>option:selected').html() != 'digital') {
            $.each($('.digital_on'), function () {
                $(this).closest('.form-group').first().addClass('digital').hide();
            });
            $.each($('.digital_off'), function () {
                $(this).closest('.form-group').first().addClass('digital').hide();
            });
        } else {
            $.each($('.digital_on'), function () {
                $(this).closest('.form-group').first().show();
            });
            $.each($('.digital_off'), function () {
                $(this).closest('.form-group').first().show();
            });
        }
    }
    $(document).delegate('.manage_inputs.edit_input, .manage_inputs.add_input', 'click', function(e) {
        requester.get($(this).data('get'), null, null).then(
            function (success) {
                $('.validation_errors').html('');
                $('.inputwidget').html(success.html);
                $('#input_type').trigger('change');
                hideNonMandatoryTranslationFields();
            },
            function (fail) {

            }
        );
    });
/**
 * Parse and show errors
 */
var parseErrorsToForm = function (errors) {
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