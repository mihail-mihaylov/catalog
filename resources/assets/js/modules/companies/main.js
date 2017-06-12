var selectField;

// quick and dirty code-jitsu for the issue of not being
// able to search in select2 in modals
$.fn.modal.Constructor.prototype.enforceFocus = function() {};

$(document).delegate('.select2-data', 'open', function(e) {
    $(this).off('open');
    var selectDataInserts = [];
    var selectData = $('.select2-data');

    $.each(selectData, function (n, elem) {
        var elem = $(elem);
        if (elem.prop('checked')) {
            var value = elem.data('select');
            selectDataInserts.push({"id" : value.id, "text" : value.name});
        }
    });
    selectField.select2("val", "");
    selectField.select2("data", null);
    $('#default_language').html("");
    if (selectField.data('select2')) {
        selectField.select2("destroy");
    }
    selectField.select2({data : selectDataInserts});
    selectField.select2({width : "100%"});
    selectField.parents('.form-group').first().removeClass('hidden');
});

function updateDefaultLanguage()
{
    selectField = $('select[name=default_language]');

    $('#timezone').select2({
       "language": {
           "noResults": function(){
               return translations.no_data;
           }
       }
    });

    selectField.select2({
       "language": {
           "noResults": function(){
               return translations.no_data;
           }
       }
    });

    $('.select2-data').trigger('open');
}
