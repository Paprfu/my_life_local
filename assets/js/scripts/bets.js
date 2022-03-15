$(document).ready(function () {
    var arr, element, clas;
    element = document.getElementById("sport-menu");
    clas = "open";
    arr = element.className.split(" ");
    if (arr.indexOf(clas) === -1) {
        element.className += " " + clas;
    }

});

function changeBetRates(id_bet) {
    $.ajax({
        url: 'assets/php/ajax/ajax_bets.php',
        type: 'POST',
        data:
            {
                method: 'changeBetRates',
                id_bet: $('#bet-select option:selected').val(),
            },
    }).done(function (data) {
        $('#bet-rates').empty().append(data);
    }).fail(function () {
        alert('Fail: Bet Rates has not been changed');
    });


}

function calculateSurpriseLevel() {
    alert($('#home-ppg').val());
    $.ajax({
        url: 'assets/php/ajax/ajax_bets.php',
        type: 'POST',
        data:
            {
                method: 'calculateSurpriseLevels',
                home_ppg: $('#home-ppg').val(),
                guest_ppg: $('#guest-ppg').val(),
            },
    }).done(function (data) {
        $('#result-ppg').empty().append(data);
    }).fail(function () {
        alert('Fail: Surprise levels has not been calculated');
    });
}

function changeBetPredictionResult() {
    var bp = $('#bet-prediction-select option:selected').val()
    $.ajax({
        url: 'assets/php/ajax/ajax_bets.php',
        type: 'POST',
        data:
            {
                method: 'changePredictionResult',
                bp: bp,
            },
    }).done(function (data) {
        $('#bet-prediction-result').empty().append(data);
        $.ajax({
            url: 'assets/php/ajax/ajax_bets.php',
            type: 'POST',
            data:
                {
                    method: 'showBetsWithPrediction',
                    bp:bp,
                },
        }).done(function (data) {
            $('#bet-prediction-div').empty().append(data);
        }).fail(function () {
            alert('Fail: Preditiction result has not been changed');
        });
    }).fail(function () {
        alert('Fail: Preditiction result has not been changed');
    });


}

function showPPGInputs() {
    $.ajax({
        url: 'assets/php/ajax/ajax_bets.php',
        type: 'POST',
        data:
            {
                method: 'showPPGInputs',
                id_match: $('#match-select option:selected').val(),
            },
    }).done(function (data) {
        if (data === 1)
            $('#ppg-div').fadeIn();
        else
            $('#ppg-div').fadeOut();
    }).fail(function () {
        alert('Fail: PPG inputs has not been showed');
    });
}

function deleteMyBet(id_bet) {
    $.ajax({
        url: 'assets/php/ajax/ajax_bets.php',
        type: 'POST',
        data:
            {
                method: 'deleteMyBet',
                id_bet: id_bet,

            },
    }).done(function () {
        $('#mybets-tr-' + id_bet).remove();
    }).fail(function (ts) {
        alert('Fail: my bet has not been deleted - ' + ts.text);
    });
}

function createAuthor() {
    $.ajax({
        url: 'assets/php/ajax/ajax_bets.php',
        type: 'POST',
        data:
            {
                method: 'createAuthor',
                name: $("#name-input").val(),

            },
    }).done(function () {
        location.reload();
    }).fail(function (ts) {
        alert('Fail: my bet has not been deleted - ' + ts.text);
    });
}

function createBetAnalysis() {
    $.ajax({
        url: 'assets/php/ajax/ajax_bets.php',
        type: 'POST',
        data:
            {
                method: 'createBetAnalysis',
                author: $("#author-select option:selected").val(),
                reliance: $("#reliance-input").val(),
                rate: $("#rate-input").val(),
                type: $("#type-input").val(),
                sport: $("#sport-input").val(),
                date: $("#date-input").val(),
                time: $("#time-input").val(),
                match: $("#match-input").val(),

            },
    }).done(function () {
        location.reload();
    }).fail(function (ts) {
        alert('Fail: my bet has not been deleted - ' + ts.text);
    });
}

