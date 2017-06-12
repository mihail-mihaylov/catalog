// Parse errors
var parseError = function(errors) {
    $.each(errors, function(key, value) {
        var div = $(document.createElement('div'));
        div.addClass('errors');
        div.css('color', '#1AB394');
        div.html(value);

        var field = $("input[name='" + key + "'], select[name='" + key + "']");

        console.log(field);
        field.parents().first().append(div);
    });
}

// Clear errors
var clearErrors = function() {
    $('.errors').remove();
}

$(document).ready(function(){
    // Show active tab by hash
    if(window.location.hash != "") {
        $('a[href="' + window.location.hash + '"]').click()
    }
});

