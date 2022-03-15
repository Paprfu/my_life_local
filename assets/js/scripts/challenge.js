$(document).ready(function () {
    let arr, element, clas;
    element = document.getElementById("user-menu");
    clas = "open";
    arr = element.className.split(" ");
    if (arr.indexOf(clas) === -1) {
        element.className += " " + clas;
    }
    console.log("<?php echo $file ?>");
});

function createChallenge(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_challenge.php',
        type: 'POST',
        data:
            {
                method: 'addChallenge',
                id: id,
                name: $('#name-input').val(),
                start: $('#start-date').val(),
                end: $('#end-date').val(),
                color: $('#color-select option:selected').val(),
                icon: $('#icon-select option:selected').val(),
            },
    }).done(function (data) {
        $('#challenges').append(data);
        $('#add-challenge-div').remove();
        $.ajax({
            url: 'assets/php/ajax/ajax_challenge.php',
            type: 'POST',
            data:
                {
                    method: 'addChallengeToTable',
                    id: id,
                },
        }).done(function (data) {
            $('#challenges-tbody').append(data);

        }).fail(function (ts) {
            alert('Fail: Challenge has not been created' + ts.text);
        });
    }).fail(function (ts) {
        alert('Fail: Challenge has not been created' + ts.text);
    });


}

function addChallengeSuccess(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_challenge.php',
        type: 'POST',
        data:
            {
                method: 'addSuccess',
                id: id,
            },
    }).done(function (data) {
        $('#challenge-counter-' + id).empty().append(data);
    }).fail(function () {
        alert('Fail: Challenge has not been changed to success');
    });
}

function deleteChallenge(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_challenge.php',
        type: 'POST',
        data:
            {
                method: 'deleteChallenge',
                id: id,
            },
    }).done(function (data) {
        $('#challenge-tr-' + id).remove();
        $('#challenge-div-' + id).remove();
        $('#challenges-count-h4').empty().append(data);
    }).fail(function (ts) {
        alert('Fail: challenge has not been deleted ' + ts.text);
    });
}

function changeSuccessDay(id, date, number, success) {
    $.ajax({
        url: 'assets/php/ajax/ajax_challenge.php',
        type: 'POST',
        data:
            {
                method: 'changeSuccessDay',
                id: id,
                date: date,
            },
    }).done(function (data) {
        if (success === 1)
            $('#'+data+'success-day-' + number).removeClass('mdi mdi-check').addClass('mdi mdi-window-close');
        else
            $('#'+data+'success-day-' + number).removeClass('mdi mdi-window-close').addClass('mdi mdi-check');
    }).fail(function (ts) {
        alert('Fail: Success day has not been changed ' + ts.text);
    });
}
