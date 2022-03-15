$( document ).ready(function() {
    var arr, element, clas;
    element = document.getElementById("sport-menu");
    clas = "open";
    arr = element.className.split(" ");
    if (arr.indexOf(clas) === -1) {
        element.className += " " + clas;
    }

});

function deleteLeague(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_leagues.php',
        type: 'POST',
        data:
            {
                method: 'deleteLeague',
                id: id,
            },
    }).done(function () {
        $('#leagues-tr-' + id).remove();
    }).fail(function () {
        alert('Fail: League has not been saved');
    });

}

function editLeague(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_leagues.php',
        type: 'POST',
        data:
            {
                method: 'editLeague',
                id: id,
            },
    }).done(function (data) {
        $('#leagues-tr-' + id).empty().append(data);
    }).fail(function () {
        alert('Fail: League has not been prepared for editing');
    });

}

function saveLeague(id) {
    var name = $('#name-league-input').val();
    var start_date = $('#start-date-league-input').val();
    var end_date = $('#end-date-league-input').val();

    $.ajax({
        url: 'assets/php/ajax/ajax_leagues.php',
        type: 'POST',
        data:
            {

                method: 'saveLeague',
                id: id,
                name: name,
                start_date: start_date,
                end_date: end_date,

            },
    }).done(function (data) {
        $('#leagues-tr-' + id).empty().append(data);
    }).fail(function () {
        alert('Fail: League has not been saved');
    });
}

function addMatchLeague(id_league) {
    var id_home_team = $('#home-team-select option:selected').val();
    var id_guest_team = $('#guest-team-select option:selected').val();
    var date = $('#match-date-input').val();
    var time = $('#match-time-input').val();

    $.ajax({
        url: 'assets/php/ajax/ajax_leagues.php',
        type: 'POST',
        data:
            {

                method: 'addMatch',
                id_league: id_league,
                id_home_team: id_home_team,
                id_guest_team: id_guest_team,
                date: date,
                time: time,

            },
    }).done(function (data) {
        alert('Match has been added to database');
    }).fail(function () {
        alert('Fail: League has not been saved');
    });

}