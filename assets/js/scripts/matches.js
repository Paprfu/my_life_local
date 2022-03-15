$( document ).ready(function() {
    var arr, element, clas;
    element = document.getElementById("sport-menu");
    clas = "open";
    arr = element.className.split(" ");
    if (arr.indexOf(clas) === -1) {
        element.className += " " + clas;
    }

});

function deleteMatch(id_match) {
    $.ajax({
        url: 'assets/php/ajax/ajax_matches.php',
        type: 'POST',
        data:
            {
                method: 'deleteMatch',
                id_match: id_match,

            },
    }).done(function (data) {
        $('#matches-tr-'+id_match).remove();
    }).fail(function (ts) {
        alert('Fail: activity has not been created - ' + ts.text);
    });
}

function editMatch(id_match) {
    $.ajax({
        url: 'assets/php/ajax/ajax_matches.php',
        type: 'POST',
        data:
            {
                method: 'editMatch',
                id_match: id_match,

            },
    }).done(function (data) {
        $('#matches-tr-'+id_match).empty().append(data);
    }).fail(function (ts) {
        alert('Fail: activity has not been created - ' + ts.text);
    });
}

function saveMatch(id_match) {
    $.ajax({
        url: 'assets/php/ajax/ajax_matches.php',
        type: 'POST',
        data:
            {
                method: 'saveMatch',
                id_match: id_match,
                score_home: $('#score-home-input').val(),
                score_guest: $('#score-guest-input').val(),
                date: $('#date-input').val(),
                time: $('#time-input').val(),
            },
    }).done(function (data) {
        $('#matches-tr-'+id_match).empty().append(data);
    }).fail(function (ts) {
        alert('Fail: match has not been saved - ' + ts.text);
    });
}