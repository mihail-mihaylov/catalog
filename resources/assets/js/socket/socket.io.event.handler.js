var app = app || {};

$(function () {
    var socket = io(location.protocol + '//' + location.hostname + ':3000', {'connect timeout': 1000});
    requester = app.requester.load();

    socket.on('connect', function() {
        // Connected, let's sign-up for to receive messages for this rooms
        socket.emit('room', "enacted-channel-" + $('#user_id').val());
    });

    socket.on('message', function(data) {
        var type = data.type;
        var date_time = data.date_time;

        if (type == 'task' || type == 'reminder') {
            var taskNotifSelector = $('#tasksCount');
            var reminderNotifSelector = $('#remindersCount');

            if (type == 'task') {
                var taskNotifCount = parseInt(taskNotifSelector.html()) + 1;
                taskNotifSelector.html(taskNotifCount);
                $('#lastTaskDateTime').html(date_time);
            } else if (type == 'reminder') {
                var reminderNotifCount = parseInt(reminderNotifSelector.html()) + 1;
                reminderNotifSelector.html(reminderNotifCount);
                $('#lastReminderDateTime').html(date_time);
            }

            $('#notificationsCount').html(parseInt(taskNotifSelector.html()) + parseInt(reminderNotifSelector.html()));
        } else if (type == 'violation') {
            var notifSelector = $('.violation_notification_count').find('span');
            var notifCount = parseInt(notifSelector.html()) + 1;
            notifSelector.html(notifCount);
        }
    });
});
