$(document).ready(function () {
    let arr, element, clas;
    element = document.getElementById("user-menu");
    clas = "open";
    arr = element.className.split(" ");
    if (arr.indexOf(clas) === -1) {
        element.className += " " + clas;
    }
    console.log("<?php echo $file ?>");
    document.title = "TF - Aktivity";

});


function createActivity(id_person) {
    $.ajax({
        url: 'assets/php/ajax/ajax_activities.php',
        type: 'POST',
        data:
            {
                method: 'createActivity',
                id_person: id_person,
                name: $('#activity-name-input').val(),
                type: $('#activity-type-input').val(),
            },
    }).done(function (data) {
        $('#activities-datatable-tbody').append(data);
    }).fail(function (ts) {
        alert('Fail: activity has not been created - ' + ts.text);
    });
}

function endActivity(id_activity) {
    $.ajax({
        url: 'assets/php/ajax/ajax_activities.php',
        type: 'POST',
        data:
            {
                method: 'endActivity',
                id_activity: id_activity,
            },
    }).done(function (data) {
        $('#activities-table-end_date-td-' + id_activity).empty().append(data);
    }).fail(function (ts) {
        alert('Fail: activity has not been created - ' + ts.text);
    });
}

function deleteActivity(id_activity) {
    $.ajax({
        url: 'assets/php/ajax/ajax_activities.php',
        type: 'POST',
        data:
            {
                method: 'deleteActivity',
                id_activity: id_activity,
            },
    }).done(function (data) {
        $('#activities-tr-' + id_activity).remove();
    }).fail(function (ts) {
        alert('Fail: activity has not been created - ' + ts.text);
    });
}


function showActivityLinksIcons() {

}

function showEditActivityModal(id_activity) {
    $.ajax({
        url: 'assets/php/ajax/ajax_activities.php',
        type: 'POST',
        data:
            {
                method: 'showEditModalActivity',
                id_activity: id_activity,
            },
    }).done(function (data) {
        $('#activity-modal-content').empty().append(data);
    }).fail(function (ts) {
        alert('Fail: activity has not been edited- ' + ts.text);
    });
}

function editActivity(id_activity) {
    $.ajax({
        url: 'assets/php/ajax/ajax_activities.php',
        type: 'POST',
        data:
            {
                method: 'editActivity',
                id_activity: id_activity,
                name: $('#activity-edit-name-input').val(),
                type: $('#activity-edit-type-input').val(),
                start_date: $('#activity-start-date-input').val(),
                start_time: $('#activity-start-time-input').val(),
            },
    }).done(function (data) {
        $('#activity-tr-' + id_activity).empty().append(data);
    }).fail(function (ts) {
        alert('Fail: activity has not been edited- ' + ts.text);
    });
}

