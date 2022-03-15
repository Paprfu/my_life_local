$(document).ready(function () {
    let arr, element, clas;
    element = document.getElementById("user-menu");
    clas = "open";
    arr = element.className.split(" ");
    if (arr.indexOf(clas) === -1) {
        element.className += " " + clas;
    }

});

function createProject(id_person) {
    const name = $('#name-input').val();
    const start = $('#start-input').val();
    const end = $('#end-input').val();
    if (!name || !start) {
        $('#msg-submit').empty().append("<div class='alert alert-danger' role='alert'>" +
            "<strong>Niečo sa pokazilo!</strong> Zmeň pár vecí a pokús sa vytvoriť projekt znova </div>");
        return;
    }
    $.ajax({
        url: 'assets/php/ajax/ajax_projects.php',
        type: 'POST',
        data:
            {
                method: 'createProject',
                id_user: id_person,
                name: name,
                start: start,
                end: end,

            },
    }).done(function (data) {
        $('#projects-list-tbody').append(data);
    }).fail(function () {
        alert('Fail: Project has not been created');
    });
}

function deleteProject(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_projects.php',
        type: 'POST',
        data:
            {
                method: 'delete',
                id: id,
            },
    }).done(function () {
        $('#projects-tr-' + id).remove();
    }).fail(function (ts) {
        alert('Fail: Project has not been deleted ' + ts.text);
    });
}

function editProject(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_projects.php',
        type: 'POST',
        data:
            {
                method: 'edit',
                id: id,

            },
    }).done(function (data) {
        $('#project-tr-' + id).empty().append(data);
    }).fail(function () {
        alert('Fail: Project can`t be edited');
    });
}

function saveProject(id, done) {
    $.ajax({
        url: 'assets/php/ajax/ajax_projects.php',
        type: 'POST',
        data:
            {
                method: 'save',
                id: id,
                name: $('#name-edit-input').val(),
                start: $('#start-edit-input').val(),
                end: $('#end-edit-input').val(),
            },
    }).done(function (data) {
        $('#project-tr-' + id).empty().append(data);
    }).fail(function () {
        alert('Fail: Project has not been saved');
    });
}

function endProject(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_projects.php',
        type: 'POST',
        data:
            {
                method: 'end',
                id: id,
            },
    }).done(function (data) {
        $('#project-tr-' + id).empty().append(data);
    }).fail(function (ts) {
        alert('Fail: Project has not been saved ' + ts.text);
    });

    $.ajax({
        url: 'assets/php/ajax/ajax_projects.php',
        type: 'POST',
        data:
            {
                method: 'numberProjectsDone',
            },
    }).done(function (data) {
        $('#counter-projects-done').empty().append(data);
    }).fail(function () {
        alert('Fail: Number of ended projects has not been changed');
    });

    $.ajax({
        url: 'assets/php/ajax/ajax_projects.php',
        type: 'POST',
        data:
            {
                method: 'numberProjectsUndone',
            },
    }).done(function (data) {
        $('#counter-projects-undone').empty().append(data);
    }).fail(function () {
        alert('Fail: Number of current projects has not been changed');
    });


}
