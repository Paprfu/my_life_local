$(document).ready(function () {
    let arr, element, clas;
    element = document.getElementById("admin-menu");
    clas = "open";
    arr = element.className.split(" ");
    if (arr.indexOf(clas) === -1) {
        element.className += " " + clas;
    }
    console.log("<?php echo $file ?>");
});


function changeAccepted(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_admin.php',
        type: 'POST',
        data:
            {
                method: 'changeAccepted',
                id: id,
            },
    }).done(function (data) {
        $('#accepted-td-' + id).empty().append(data);
    }).fail(function () {
        alert('Projekt sa nedal vytvoriť');
    });
}

function deleteUser(id) {
    if (id === 1) {
        alert('Admin sa nedá odstrániť');
        return;
    }
    $.ajax({
        url: 'assets/php/ajax/ajax_admin.php',
        type: 'POST',
        data:
            {
                method: 'deleteUser',
                id: id,
            },
    }).done(function (data) {
        $('#users-table-tr-' + id).empty();
    }).fail(function () {
        alert('Použivateľ sa nedá odstrániť');
    });

}

function showUsers() {


    $("#finding").on('input', function () {
        $.ajax({
            url: 'assets/php/ajax/ajax_admin.php',
            type: 'POST',
            data:
                {
                    method: 'showUsers',
                    finding: $('#finding').val(),
                },
        }).done(function (data) {
            $('#users-popup').empty().append(data);
        }).fail(function () {
            alert('Použivateľ sa nedá odstrániť');
        });
    });
}


function addIcon() {
    const icon = $('#icon-input').val();
    const type = $('#type-select').val();
    $.ajax({
        url: 'assets/php/ajax/ajax_admin.php',
        type: 'POST',
        data:
            {
                method: 'addIcon',
                icon: icon,
                type: type,
            },
    }).done(function (alert) {
        $('#msg-submit').empty().append(alert);
        $('#admin-icons-div').append("<div class='col-sm-6 col-md-4 col-lg-3'><i class='"+type+" "+ icon +"'></i>"+type+" "+icon+"</div>");
    }).fail(function (ts) {
        alert('Fail: Icon has not been added to database ' + ts.text);
    });

}
