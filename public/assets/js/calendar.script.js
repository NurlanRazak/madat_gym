$(document).ready(function() {
    /* initialize the external events
            -----------------------------------------------------------------*/


    function initEvent() {
        $('#external-events .fc-event').each(function() {

            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                color: $(this).css('background-color'),
                stick: true // maintain when user navigates (see docs on the renderEvent method)
            });

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true, // will cause the event to go back to its
                revertDuration: 0 // original position after the drag
            });

        });
    }
    initEvent();


    /* initialize the calendar
    -----------------------------------------------------------------*/
    var newDate = new Date,
    date = newDate.getDate(),
    month = newDate.getMonth(),
    year = newDate.getFullYear();
    
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        themeSystem: "bootstrap4",
        initialView: "dayGridWeek",
        editable: false,
        eventLimit: true,


        events: $('#calendar').data('events').map(function(item) {
            item.start =  new Date(Date.parse(item.start))
            item.end =  new Date(Date.parse(item.end))
            return item
        })
        // [{
        //     title: "Break time",
        //     start: new Date(year, month, 1),
        //     allDay: !0,
        //     color: "#ffc107"
        // }, {
        //     title: "Office Hour",
        //     start: new Date(year, month, 3)
        // }, {
        //     title: "Work on a Project",
        //     start: new Date(year, month, 9),
        //     end: new Date(year, month, 12),
        //     allDay: !0,
        //     color: "#d22346"
        // }, {
        //     title: "Work on a Project",
        //     start: new Date(year, month, 17),
        //     end: new Date(year, month, 19),
        //     allDay: !0,
        //     color: "#d22346"
        // }, {
        //     id: 999,
        //     title: "Go to Long Drive",
        //     start: new Date(year, month, date - 1, 15, 0)
        // }, {
        //     id: 999,
        //     title: "Go to Long Drive",
        //     start: new Date(year, month, date + 3, 15, 0)
        // }, {
        //     title: "Work on a New Project",
        //     start: new Date(year, month, date - 3),
        //     end: new Date(year, month, date - 3),
        //     allDay: !0,
        //     color: "#ffc107"
        // }, {
        //     title: "Food ",
        //     start: new Date(year, month, date + 7, 15, 0),
        //     color: "#4caf50"
        // }, {
        //     title: "Go to Library",
        //     start: new Date(year, month, date, 8, 0),
        //     end: new Date(year, month, date, 14, 0),
        //     color: "#ffc107"
        // }, {
        //     title: "Go for Walk",
        //     start: new Date(year, month, 25),
        //     end: new Date(year, month, 27),
        //     allDay: !0,
        //     color: "#ffc107"
        // }, {
        //     title: "Work on a Project",
        //     start: new Date(year, month, date + 8, 20, 0),
        //     end: new Date(year, month, date + 8, 22, 0)
        // }]
    });




});
