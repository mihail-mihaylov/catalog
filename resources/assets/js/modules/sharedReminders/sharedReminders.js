 $(document).delegate('select[name="intended_for"]', 'change', function () {
     var element = $(this);
     var intendedFor = element.val();

     if (intendedFor == 'users_groups') {
         $('.usersHolder').removeClass('hidden');
         $('.usersTrackedObjectHolder').addClass('hidden');
         $('.groupsHolder').removeClass('hidden');
         $('.trackedObjectsHolder').addClass('hidden');
         $('.metricsHolder').addClass('hidden');
         $('.dateHolder').removeClass('hidden');
         // $('.isGlobalHolder').removeClass('hidden');
     } else if (intendedFor == 'tracked_object') {
         $('.usersHolder').addClass('hidden');
         // $('.isGlobalHolder').addClass('hidden');
         $('.groupsHolder').addClass('hidden');

         $('.trackedObjectsHolder').removeClass('hidden');
         $('#tracked_object').select2('val', '');

         $('.metricsHolder').removeClass('hidden');
         $('.dateHolder').removeClass('hidden');
     }
 });


 $(document).delegate('select[name="tracked_object"]', 'change', function () {
     var element = $(this);
     var tracked_object_id = element.val();
     var usersSelect = $('#usersTrackedObject');

     if (tracked_object_id != '')
     {
         requester.get('/reminders/trackedObjectUsers/'+tracked_object_id).then(
             function (success) {
                 $('.usersTrackedObjectHolder').removeClass('hidden');

                 usersSelect.find('option').remove();
                 usersSelect.select2({
                     data: transform_array(success.users).values
                 });

                 usersSelect.select2("val", transform_array(success.users).ids);
             },
             function (fail) {
                 console.log('fail');
             }
         )
     }
 });

 function transform_array(data) {
     var new_data = [];
     var ids = [];
     for (var n in data) {
         new_data.push({id:data[n]['id'], text:data[n]['first_name']+' '+data[n]['last_name']});
         ids.push(data[n]['id'])
     }
     return {ids:ids, values:new_data};
 }