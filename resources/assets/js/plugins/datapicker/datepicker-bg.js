/* Bulgarian initialisation for the jQuery UI date picker plugin. */
/* Written by Stoyan Kyosev (http://svest.org). */
// jQuery(function($){
//     $.datepicker.regional['bg'] = {
//         closeText: 'затвори',
//         prevText: '&#x3c;назад',
//         nextText: 'напред&#x3e;',
//                 nextBigText: '&#x3e;&#x3e;',
//         currentText: 'днес',
//         monthNames: ['Януари','Февруари','Март','Април','Май','Юни',
//         'Юли','Август','Септември','Октомври','Ноември','Декември'],
//         monthNamesShort: ['Яну','Фев','Мар','Апр','Май','Юни',
//         'Юли','Авг','Сеп','Окт','Нов','Дек'],
//         dayNames: ['Неделя','Понеделник','Вторник','Сряда','Четвъртък','Петък','Събота'],
//         dayNamesShort: ['Нед','Пон','Вто','Сря','Чет','Пет','Съб'],
//         dayNamesMin: ['Не','По','Вт','Ср','Че','Пе','Съ'],
//                 weekHeader: 'Wk',
//         dateFormat: 'dd.mm.yy',
//                 firstDay: 1,
//         isRTL: false,
//                 showMonthAfterYear: false,
//                 yearSuffix: ''};
//     $.datepicker.setDefaults($.datepicker.regional['bg']);
// });
/**
 * Bulgarian translation for bootstrap-datepicker
 * url: https://github.com/eternicode/bootstrap-datepicker/blob/master/js/locales/bootstrap-datepicker.bg.js
 */
;(function($){
    $.fn.datepicker.dates['bg'] = {
        days: ["Неделя", "Понеделник", "Вторник", "Сряда", "Четвъртък", "Петък", "Събота"],
        daysShort: ["Нед", "Пон", "Вто", "Сря", "Чет", "Пет", "Съб"],
        daysMin: ["Н", "П", "В", "С", "Ч", "П", "С"],
        months: ["Януари", "Февруари", "Март", "Април", "Май", "Юни", "Юли", "Август", "Септември", "Октомври", "Ноември", "Декември"],
        monthsShort: ["Ян", "Фев", "Мар", "Апр", "Май", "Юни", "Юли", "Авг", "Сеп", "Окт", "Ное", "Дек"],
        today: "днес"
    };
}(jQuery));

