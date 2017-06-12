var app = app || {};

app.notifications = (function () {
    function Notifications() {
      
    }
    
    var tasksCount = 0;

    Notifications.prototype.setTasksCount = function (count) {
        tasksCount = count;
        reload();
    };

    function reload() {
        var count  = tasksCount;
        $('#tasksCount').html(tasksCount);
        $('#notificationsCount').html(count);
    }

    return {
        load: function () {
            return new Notifications();
        }
    }
}());

// Mark violations as seen
$(document).delegate('#clear_violations', 'click', function (e) {
    var action = $(this).data('action');

    requester.post(action, null, null).then(
        function (success) {
            $('#violationsCount').html(0);
            $('.notification_list').remove();
        },
        function (fail) {
            console.log(fail);
        }
    );
});
