var modal = $('#baseModal');

function showModal(title) {

    if (typeof (title) == 'undefined') {
        title = false;
    }

    var modal = $('#baseModal');

    if (title != false) {
        modal.find('#baseModalTitle').html(title);
    } else {
        modal.find('.modal-header').hide();
    }

    modal.find('.modal-body-content').hide();
    modal.find('.modal-body-loading').show();
    modal.find('.modal-footer').hide();
    modal.modal('show');
    $(document).trigger('main.showModal');
}

function setModalHtml(html) {
    var modal = $('#baseModal');
    // remove this hardcoded number
    // pls :D
    modal.find('.modal-body-loading').fadeOut(250, function () {
        modal.find('.modal-body-content').html('<div class="validation_errors"></div>' + html);
        modal.find('.modal-body-content').fadeIn(300);
    });
}

$(document).delegate('#doneModalButton', 'click', function () {
    $(document).trigger('main.modal.click.done');
});

$(document).delegate('#closeModalButton', 'click', function () {
    $(document).trigger('main.modal.click.close');
});

function ScrollToElement(selector, time) {
    $('html, body').animate({
        scrollTop: $(selector).offset().top
    }, time);
}

function closeModal() {
    var modal = $('#baseModal');
    modal.modal('hide');
    modal.find('.modal-body-content').html('');
    $(document).trigger('main.modal.click.close');
}

function clearModal() {
    var modal = $('#baseModal');
    modal.find('.modal-body-content').html('');
}

/**
 * Parse and show errors
 */
var appendErrorsToModal = function (errors) {
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

$(document).delegate('form[data-submit]', 'submit', function () {

    baseModal = $('#baseModal');
    baseModal.find('.modal-body-loading').show();
    var form = $(this);
    var data = form.serialize()
    var action = form.attr('action');

    var method = undefined;
    if (form.find('input[name="_method"]').length) {
        method = form.find('input[name="_method"]').val();
    } else {
        method = form.attr('method');
    }

    if (method.toLowerCase() == "post") {
        requester.post(action, null, data).then(function (success) {
            baseModal.find('.modal-body-loading').hide();

            var html = $(success.html);
            var table = $('#' + form.data('table-name'));
            if (table.length) {
                table.appendRow(html);
            }
            closeModal();
            $(document).trigger('modal_form_submited', success);
        }, function (error) {
            baseModal.find('.modal-body-loading').hide();

            appendErrorsToModal(error);
        });
    } else if (method.toLowerCase() == "put") {
        requester.put(action, null, data).then(function (success) {
            $('#baseModal').find('.modal-body-loading').hide();
            var html = $(success.html);
            var table = $('#' + form.data('table-name'));
            var attrId = html.attr('id');
            var elements = htmlToArray(success.html);

            if (typeof attrId !== typeof undefined && attrId !== false) {
                table.dataTable().api()
                    .row($('#'+html.attr('id')))
                    .data(elements)
                    .draw('full-hold');
            }

            closeModal();
            $(document).trigger('modal_form_submited', success);
        }, function (error) {
            $('#baseModal').find('.modal-body-loading').hide();
            appendErrorsToModal(error);
        });
    }
    return false;
});

$(document).delegate('button[data-update]', 'click', function ()
{
    var button = $(this);
    var action = button.data('action');

    requester.get(action, {}, {}).then(function (success)
    {
        var html = $(success.html);
        var elements = htmlToArray(success.html)

        // Update row
        button.parents('table').dataTable().api()
            .row($('#'+html.attr('id')))
            .data(elements)
            .draw('full-hold');

        closeModal();
        $(document).trigger('update_entity', success);
    }, function (error) {
        appendErrorsToModal(error);
    });

    return false;
});

$(document).delegate('button[data-delete]', 'click', function ()
{
    var button = $(this);
    var action = button.data('action');

    requester.delete(action, {}, {}).then(function (success)
    {
        var html = $(success.html);
        var elements = htmlToArray(success.html);

        // Update row
        button.parents('table').dataTable().api()
            .row($('#'+html.attr('id')))
            .data(elements)
            .draw('full-hold');

        closeModal();
        $(document).trigger('delete_entity', success);
    },
    function (error) {
        appendErrorsToModal(error);
    });
});


$(document).delegate('button[data-get], a[data-get]', 'click', function (event) {
    var element = $(this);
    if (element.hasClass('disabled')) {
        return;
    }
    element.addClass('disabled');
    showModal(element.data('title'));
    var action = element.data('action');
    requester.get(action).then(function (success) {
        setModalHtml(success.html);
        element.removeClass('disabled');
        $(document).trigger('modal_form_loaded');
    }, function (error) {
        appendErrorsToModal(error);
        element.removeClass('disabled');
    });
});

function htmlToArray(html)
{
    var elements = [];

    $(html).has('td').each(function() {
        $('td', $(this)).each(function(index, item) {
            elements.push($(item).html());
        });
    });
    // console.log(elements);
    return elements;
}
