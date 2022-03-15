/*
 Template Name: Inspire - Bootstrap 4 Admin Dashboard
 Author: UIdeck
 Website: www.uideck.com
File: Calendar init js
 */

!function ($) {
    "use strict";

    var CalendarPage = function () {
    };

    CalendarPage.prototype.init = function () {

        //checking if plugin is available
        if ($.isFunction($.fn.fullCalendar)) {
            /* initialize the external events */
            $('#external-events .fc-event').each(function () {
                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                };

                // store the Event Object in the DOM element so we can get to it later
                $(this).data('eventObject', eventObject);

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 999,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0 //  original position after the drag
                });

            });

            /* initialize the calendar */

            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            var cevents = [];
            $.ajax({
                url: 'assets/php/ajax/events.php',
                type: 'get',
                dataType: 'JSON',

                success: function (data) {
                    var len = data.length;
                    var cevents = [];
                    for (var i = 0; i < len; i++) {
                        cevents.push({
                            title: data[i].name,
                            start: new Date(data[i].start),
                            end: new Date(data[i].end)
                        })
                    }
                    $('#calendar').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,basicWeek,basicDay'
                        },
                        editable: true,
                        eventLimit: true, // allow "more" link when too many events
                        droppable: true, // this allows things to be dropped onto the calendar !!!
                        drop: function (date, allDay) { // this function is called when something is dropped

                            // retrieve the dropped element's stored Event Object
                            var originalEventObject = $(this).data('eventObject');

                            // we need to copy it, so that multiple events don't have a reference to the same object
                            var copiedEventObject = $.extend({}, originalEventObject);

                            // assign it the date that was reported
                            copiedEventObject.start = date;
                            copiedEventObject.allDay = allDay;

                            // render the event on the calendar
                            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                            // is the "remove after drop" checkbox checked?
                            if ($('#drop-remove').is(':checked')) {
                                // if so, remove the element from the "Draggable Events" list
                                $(this).remove();
                            }


                        },

                        events: cevents,
                    });


                },
                error: function () {
                    alert('Nepodarilo sa načítať eventy');
                }
            });


            /*Add new event*/
            // Form to add new event

            $("#add_event_form").on('submit', function (ev) {
                ev.preventDefault();

                var $event = $(this).find('#name-event'),
                    event_name = $event.val();
                var $start = $(this).find('#start-date'),
                    start = $start.val();
                var $end = $(this).find('#end-date'),
                    end = $end.val();

                if (event_name.length >= 3) {

                    var newid = "new" + "" + Math.random().toString(36).substring(7);

                    // Create Event Entry

                    $.ajax({
                        url: 'assets/php/ajax/ajax.php',
                        type: 'POST',
                        data:
                            {

                                method: 'addEventToCalendar',
                                name: event_name,
                                start: start,
                                end: end,

                            },
                    }).done(function () {

                    }).fail(function () {
                        alert('Nepodarilo sa pridať event');
                    });

                    var eventObject = {
                        title: $.trim($("#" + newid).text()) // use the element's text as the event title
                    };

                    // store the Event Object in the DOM element so we can get to it later
                    $("#" + newid).data('eventObject', eventObject);

                    // Reset draggable
                    $("#" + newid).draggable({
                        revert: true,
                        revertDuration: 0,
                        zIndex: 999
                    });

                    // Reset input
                    $event.val('').focus();
                } else {
                    $event.focus();
                }
            });

        } else {
            alert("Kalendár nie je nainštalovaný");
        }
    }

        ,
        //init

        $.CalendarPage = new CalendarPage, $.CalendarPage.Constructor = CalendarPage
}(window.jQuery)  ,

//initializing 
    function ($) {
        "use strict";
        $.CalendarPage.init()
    }(window.jQuery);


