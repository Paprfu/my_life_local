$(document).ready(function () {
    $('#pripojenie-div').fadeOut();
    let arr, element, clas;
    element = document.getElementById("user-menu");
    clas = "open";
    arr = element.className.split(" ");
    if (arr.indexOf(clas) === -1) {
        element.className += " " + clas;
    }
    document.title = "TF | Tasks";
});



function showConnect() {
    var type = $('#select-type option:selected').val();
    if (type !== "normal") {
        $('#pripojenie-div').fadeIn();
        $.ajax({
            url: 'assets/php/ajax/ajax_tasks.php',
            type: 'POST',
            data:
                {
                    method: 'showConnect',
                    type: type,
                },
        }).done(function (data) {
            $('#pripojenie-select').empty().append(data);
        }).fail(function () {
            alert('Fail: connection has not been shown!');
        });

    } else {
        $('#pripojenie-div').fadeOut();
    }
}

function addTask(id_person) {
    let ok = true;
    let errorMsg = $("#error-msg");
    let connect = null;
    let type = $('#select-type option:selected').val();

    if (type !== "normal") {
        connect = $('#pripojenie-select option:selected').val();
    }
    errorMsg.empty();
    var name = $("#name-input").val();
    if (name.length < 1) {
        errorMsg.append("<div class=\"alert alert-danger alert-raised\" role=\"alert\">\n" +
            "                        <i class=\"lni-close\" aria-hidden=\"true\"></i> <strong>Chyba: </strong>Názov úlohy nebol zadaný" +
            "                      </div>");
        ok = false;
    }

    if (ok) {
        $.ajax({
            url: 'assets/php/ajax/ajax_tasks.php',
            type: 'POST',
            data:
                {
                    method: 'addTask',
                    id_person: id_person,
                    name: name,
                    date: $('#date-input').val(),
                    time: $('#time-input').val(),
                    type: type,
                    connect: connect,
                },
        }).done(function (data) {
            $('#tasks-to-do').append(data);
            $('#addTaskModal').modal('hide');
        }).fail(function () {
            alert('Úlohu sa nepodarilo pridať');
        });
    }
}


function changeTask(id_task) {
    const checked = $('#task-input-' + id_task).is(':checked');
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'changeTask',
                id_task: id_task,
                checked: checked,

            },
    }).done(function (data) {
        $('#task-' + id_task).remove();
        if (checked)
            $('#tasks-done').append(data);
        else
            $('#tasks-to-do').append(data);
    }).fail(function () {
        alert('The has has not been changed!');
    });

}

function deleteTask(id_task) {
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'deleteTask',
                id_task: id_task,

            },
    }).done(function () {
        $('#archived-tasks-table-tr-' + id_task).remove();
        $('#task-' + id_task).remove();
    }).fail(function () {
        alert('Úlohu sa nepodarilo vymazať');
    });

}

function returnTask(id, done) {
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'returnTask',
                id: id,

            },
    }).done(function (data) {
        if (done)
            $('#tasks-done').append(data);
        else
            $('#tasks-to-do').append(data);
        $('#archived-tasks-table-tr-' + id).remove();
    }).fail(function () {
        alert('Úlohu sa nepodarilo odstrániť');
    });
}

function archiveTask(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'archiveTask',
                id: id,

            },
    }).done(function (data) {
        $('#task-' + id).remove();
        $('#archived-tasks').append(data);

    }).fail(function () {
        alert('Úloha nebola archivovaná');
    });

}

function changeTimerTask(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'changeTimerTask',
                id: id,

            },
    }).done(function (data) {
        $('#icon-timer-' + id).empty().append(data);

    }).fail(function () {
        alert('Úlohu sa nepodarilo spustiť');
        alert('Úlohu sa nepodarilo spustiť');
    });

}


function addProblem(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'addProblem',
                id_task: id,
                name: $('#name-input').val(),
                note: $('#note-textarea').val(),
            },
    }).done(function (data) {
        $('#task-problems-tbody').append(data);
    }).fail(function (ts) {
        alert('Problém sa nepdoarilo pridať ' + ts.responseText);
    });

}

function addSolution(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'addSolution',
                id_problem: id,
                name: $('#solution-problem-input-' + id).val(),
            },
    }).done(function (data) {
        $('#problem-solutions-' + id).append(data);

    }).fail(function () {
        alert('Problém sa nepdoarilo pridať');
    });

}

function changeSolution(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'changeSolution',
                id: id,
            },
    }).done(function (data) {

    }).fail(function () {
        alert('Riešenie sa nepodarilo zmeniť');
    });

}


function deleteSolution(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'deleteSolution',
                id: id,
            },
    }).done(function () {
        $('#solution-' + id).remove();

    }).fail(function () {
        alert('Riešenie sa nepodarilo vymazať');
    });
}

function deleteProblem(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'deleteProblem',
                id: id,
            },
    }).done(function (numberOfProblems) {
        $('#problems-task-tr-' + id).remove();
        $('#counter-1').empty().append(--numberOfProblems);
    }).fail(function (ts) {
        alert('Fail: Problem has not been deleted ' + ts.text);
    });
}

function changeConfirmButton(id, method) {
    switch (method) {
        case 'edit':
            $(".confirmButton").on("click", function () {
                this.ajax({
                    url: 'assets/php/ajax/ajax_tasks.php',
                    type: 'POST',
                    data:
                        {
                            method: 'editTask',
                            id: id,
                            name: name,
                            date: $('#date-input').val(),
                            time: $('#time-input').val(),
                            type: type,
                            connect: connect,

                        },
                }).done(function (data) {
                    if (type === 'undone')
                        $('#tasks-to-do').empty().append(data);
                    else if (type === 'done')
                        $('#tasks-done').empty().append(data);
                    else
                        $('#archived-tasks').empty().append(data);


                }).fail(function () {
                    alert('Problém sa nepodarilo vymazať');
                });

            });
            break;
        case 'delete':
            deleteTask(id);
            break;
        case 'archive':
            $(".confirmArchiveTaskButton").on("click", function () {
                archiveTask(id);
            });
            break;
    }

}


function showIcons(type, icons) {
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'showIcons',
                type: type,
                icons: icons,
            },
    }).done(function (data) {
        if (type === 'undone')
            $('#tasks-to-do').empty().append(data);
        else if (type === 'done')
            $('#tasks-done').empty().append(data);
        else
            $('#archived-tasks').empty().append(data);


    }).fail(function (ts) {
        alert('Fail: Icons has not been shown. ' + ts.responseText);
    });

}


function showModal(id, type) {

    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'showModal',
                id: id,
                type: type,
            },
    }).done(function (data) {
        $('#modal').empty().append(data);
    }).fail(function () {
        alert('Model sa nepdoarilo zobraziť');
    });

}

function editTask(id) {
    var ok = true;
    var errorMsg = $("#error-msg");
    var connect = null;
    var type = $('#select-type option:selected').val();

    if (type !== "normal") {
        connect = $('#pripojenie-select option:selected').val();
    }
    errorMsg.empty();
    var name = $("#name-input").val();
    if (name.length < 1) {
        errorMsg.append("<div class=\"alert alert-danger alert-raised\" role=\"alert\">\n" +
            "                        <i class=\"lni-close\" aria-hidden=\"true\"></i> <strong>Chyba: </strong>Názov úlohy nebol zadaný" +
            "                      </div>");
        ok = false;
    }

    if (ok) {
        $.ajax({
            url: 'assets/php/ajax/ajax_tasks.php',
            type: 'POST',
            data:
                {
                    method: 'editTask',
                    id: id,
                    name: name,
                    date: $('#date-input').val(),
                    time: $('#time-input').val(),
                    type: type,
                    connect: connect,

                },
        }).done(function (data) {
            $('#modal').empty().append(data);
        }).fail(function () {
            alert('Model sa nepdoarilo zobraziť');
        });
    }

}

function explorerFiles(id) {
    document.getElementById('uploadfile-' + id).click();
    document.getElementById('uploadfile-' + id).onchange = function () {
        files = document.getElementById('uploadfile-' + id).files;
        $('#uploadIcon-' + id).addClass("uploaded-file").prop('title', 'Nahrať novú fotografiu');
        ajax_file_upload_table(files, 'solution', id);

    };
}

function editArchivedTask(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'editArchivedTask',
                id: id,
            },
    }).done(function (data) {
        $('#archived-tasks-table-tr-' + id).empty().append(data);
    }).fail(function () {
        alert('Ùloha sa nedá editovať');
    });
}

function saveArchivedTask(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'saveArchivedTask',
                id: id,
            },
    }).done(function (data) {
        $('#modal').empty().append(data);
    }).fail(function () {
        alert('Model sa nepdoarilo zobraziť');
    });
}

function deleteArchivedTask(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'deleteArchivedTask',
                id: id,
                name: name,
                date: $('#date-input').val(),
                time: $('#time-input').val(),
                type: type,
                connect: connect,

            },
    }).done(function () {
        $('#archived-tasks-table-tr-' + id).remove();
    }).fail(function () {
        alert('Archivovanú úlohu sa nepodarilo odstrániť');
    });
}

function solveProblem(id, numberOfProblems) {
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'solveProblem',
                id: id,
            },
    }).done(function (data) {
        $('#problem-task-td-' + id).empty().append("<span><i class='lni lni-check-mark-circle'></i></span>");
        $('#problem-task-action-div-' + id).empty().append(data);
        $('#counter-1').empty().append(++numberOfProblems);
    }).fail(function (ts) {
        alert('Fail: Problem has not been solved ' + ts.text);
    });
}

function unsolveProblem(id, numberOfProblems) {
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'unsolveProblem',
                id: id,
            },
    }).done(function (data) {
        $('#problem-task-td-' + id).empty().append("<span><i class='lni lni-close'></i></span>");
        $('#problem-task-action-div-' + id).empty().append(data);
        $('#counter-1').empty().append(--numberOfProblems);

    }).fail(function (ts) {
        alert('Fail: Problem has not been unsolved ' + ts.text);
    });
}


function showEditModalProblem(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'showEditModalProblem',
                id: id,
            },
    }).done(function (data) {
        $('#problem-modal-content-div').empty().append(data);
    }).fail(function (ts) {
        alert('Fail: Edit problem modal has not been shown ' + ts.text);
    });
}

function editProblem(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_tasks.php',
        type: 'POST',
        data:
            {
                method: 'editProblem',
                id: id,
                name: $("#name-problem-input").val(),
                note: $("#note-problem-textarea").val(),
            },
    }).done(function (data) {
        $('#problems-task-tr-' + id).empty().append(data);
    }).fail(function (ts) {
        alert('Fail: Edit problem modal has not been shown ' + ts.text);
    });
}


