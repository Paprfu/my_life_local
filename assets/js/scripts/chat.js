$('#chat-controls').fadeOut();

function showChat(id) {


        $.ajax({
            url: 'assets/php/ajax/ajax_chat.php',
            type: 'POST',
            data:
                {

                    method: 'showChat',
                    id_person: id,

                },
        }).done(function (data) {
            $('#chat').empty().append(data);
            $('#chat-controls').fadeIn();
        }).fail(function () {
            $('#button-send-message').removeClass().addClass('alert-success').empty().append('Otázka nebola pridaná');
        });

}

function refreshChat(id) {


    $.ajax({
        url: 'assets/php/ajax/ajax_chat.php',
        type: 'POST',
        data:
            {

                method: 'refreshChat',
                id_person: id,

            },
    }).done(function (data) {
        $('#chat').empty().append(data);
        $('#button-send-message').empty().append("<button type='button' onclick='sendMessage(" + id + ")' class='btn btn-common btn-circle btn-lg'><i class='lni-pointer'></i> </button>");
    }).fail(function () {
        $('#button-send-message').removeClass().addClass('alert-success').empty().append('Otázka nebola pridaná');
    });

}

function sendMessage(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_chat.php',
        type: 'POST',
        data:
            {

                method: 'sendMessage',
                id_person: id,
                message: $('#message').val(),

            },
    }).done(function (data) {
        $('#chat-messages').append(data);
        $('#message').value = "";
    }).fail(function () {
        $('#button-send-message').removeClass().addClass('alert-danger').empty().append('Správu s anepodarilo odoslať');
    });
}