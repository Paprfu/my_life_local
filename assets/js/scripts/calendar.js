function deleteCalendarEvent(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_calendar.php',
        type: 'POST',
        data:
            {
                method: 'deleteCalendarEvent',
                id: id,
            },
    }).done(function (data) {
        $('#calendar-table-tr-' + id).remove();
    }).fail(function () {
        alert('Udalosť kalendára bola vymazaná');
    });
}

$(window).on('load', function () {

    let arr, element, clas;
    element = document.getElementById("app-menu");
    clas = "open";
    arr = element.className.split(" ");
    if (arr.indexOf(clas) === -1) {
        element.className += " " + clas;
    }
});

function createCalendarEvent(id_person) {
    $.ajax({
        url: 'assets/php/ajax/ajax_calendar.php',
        type: 'POST',
        data:
            {
                method: 'createCalendarEvent',
                id_person: id_person,
                start_date: $("#start-date-input").val(),
                start_time: $("#start-time-input").val(),

                end_date: $("#end-date-input").val(),
                end_time: $("#end-time-input").val(),
                name: $("#name-input").val(),

            },
    }).done(function () {
       window.location = "calendar.php";
    }).fail(function () {
        alert('Udalosť kalendára nebola pridaná');
    });
}


