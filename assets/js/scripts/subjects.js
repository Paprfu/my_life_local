$(document).ready(function () {
    let arr, element, clas;
    element = document.getElementById("education-menu");
    clas = "open";
    arr = element.className.split(" ");
    if (arr.indexOf(clas) === -1) {
        element.className += " " + clas;
    }
    document.title = "TF | Predmety";
});


function addQuestion(subject) {
    const question = $("#question-input").val();
    const category = $("#category-select option:selected").val();
    const answer = $("#answer-textarea").val();
    $.ajax({
        url: 'assets/php/ajax/ajax.php',
        type: 'POST',
        data:
            {

                method: 'addQA',
                subject: subject,
                question: question,
                category: category,
                answer: answer,

            },
    }).done(function (data) {
        $('#accordion').empty().append(data);
        $('#msg-submit-question-div').removeClass().addClass('alert-success').empty().append('Otázka bola úspešne pridaná');

    }).fail(function () {
        $('#msg-submit-question-div').removeClass().addClass('alert-success').empty().append('Otázka nebola pridaná');
    });
}

function addCategory(subject) {
    var category = $("#category-input").val();

    $.ajax({
        url: 'assets/php/ajax/ajax.php',
        type: 'POST',
        data:
            {

                method: 'addCategory',
                category: category,
                subject: subject,

            },
    }).done(function (data) {
        $('#category-select').empty().append(data);
        $('#msg-submit-category-div').removeClass().addClass('alert-success').empty().append('Kategória bola úspešne pridaná');

    }).fail(function () {
        $('#msg-submit-category-div').removeClass().addClass('alert-success').empty().append('Otázka nebola pridaná');
    });
}


function editSubject(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_subjects.php',
        type: 'POST',
        data:
            {
                method: 'editSubject',
                id: id,
                name: $('#subject-name-input').val(),
                from:$('#from-input').val(),
                to:$('#to-input').val(),
                max_points:$('#max-points-input').val(),
                max_exam_points:$('#max-exam-points-input').val(),
                mark:$('#mark-input').val(),
                points:$('#points-input').val(),
                exam_points: $('#exam-points-input').val(),
            },
    }).done(function (data) {
        $('#subjects-tr-'+id).empty().append(data);
    }).fail(function () {
        alert('Úprava predmetu nebola možná')
    });
}

function saveSubject(id) {
    var name = $('#name-subject-input').val();
    $.ajax({
        url: 'assets/php/ajax/ajax_subjects.php',
        type: 'POST',
        data:
            {
                method: 'saveSubject',
                id: id,
                name: name,
            },
    }).done(function (data) {
        $('#subject-table-tr-'+id).empty().append(data);

    }).fail(function () {
        alert('Uloženie predmetu nebola možná')
    });
}

function deleteSubject(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_subjects.php',
        type: 'POST',
        data:
            {

                method: 'deleteSubject',
                id: id,

            },
    }).done(function () {
        $('#subjects-tr-'+id).remove();
    }).fail(function () {
        alert('Vymazanie predmetu nebola možná')
    });


}

function createSubject() {
    const name = $('#add-subject-name-input').val();
    const start = $('#add-from-input').val();
    const end = $('#add-to-input').val();
    const max_points = $('#add-max-points-input').val();
    const max_exam_points = $('#add-max-exam-points-input').val();
    $.ajax({
        url: 'assets/php/ajax/ajax_subjects.php',
        type: 'POST',
        data:
            {

                method: 'createSubject',
                name: name,
                from: start,
                to: end,
                max_points: max_points,
                max_exam_points: max_exam_points,

            },
    }).done(function (data) {
        $('#subjects-tbody').append(data);
    }).fail(function () {
        alert('Fail: Subject has not been created!')
    });


}

function createSchoolEvent(id) {
    const name = $('#name-input').val();
    const date = $('#date-input').val();
    const type = $('#type-select option:selected').val();
    const text = $('#text-textarea').val();
    const points = $('#points-input').val();
    $.ajax({
        url: 'assets/php/ajax/ajax_subjects.php',
        type: 'POST',
        data:
            {
                method: 'createSchoolEvent',
                id: id,
                name: name,
                date: date,
                type: type,
                text: text,
                points: points,
            },
    }).done(function (data) {
        if(type === 'exercise')
            $('#exercises-tbody').empty().append(data);
        else if(type === 'lecture')
            $('#lecture-tbody').empty().append(data);
        else if(type === 'activity')
            $('#activities-tbody').empty().append(data);
        else if(type === 'test')
            $('#tests-tbody').empty().append(data);
        else if(type === 'work')
            $('#tests-tbody').empty().append(data);
         else
            $('#msg-submit').empty().append(data);
    }).fail(function () {
        alert('Vytvorenie predmetu nebolo možné')
    });


}

function createSchoolEvent_Type(id, type) {
    var name = $('#name-'+type+'-input').val();
    var date = $('#date-'+type+'-input').val();
    var time = $('#time-'+type+'-input').val();
    var text = $('#text-'+type+'-input').val();
    var points =  $('#points-'+type+'-input').val();
    $.ajax({
        url: 'assets/php/ajax/ajax_subjects.php',
        type: 'POST',
        data:
            {
                method: 'createSchoolEvent',
                id: id,
                name: name,
                date: date,
                time: time,
                type: type,
                text: text,
                points: points,
            },
    }).done(function (data) {
        if(type === 'exercise')
            $('#exercises-tbody').empty().append(data);
        else if(type === 'lecture')
            $('#lecture-tbody').empty().append(data);
        else if(type === 'activity')
            $('#activities-tbody').empty().append(data);
        else if(type === 'test')
            $('#tests-tbody').empty().append(data);
        else if(type === 'work')
            $('#tests-tbody').empty().append(data);
        else
            $('#msg-submit').empty().append(data);
    }).fail(function () {
        alert('Vytvorenie predmetu nebolo možné')
    });


}

function editSchoolEvent(id, type, number) {
    $.ajax({
        url: 'assets/php/ajax/ajax_subjects.php',
        type: 'POST',
        data:
            {
                method: 'editSchoolEvent',
                id: id,
                number: number,
                type: type,
            },
    }).done(function (data) {
        if(type === 'exercise')
            $('#exercises-table-tr-'+id).empty().append(data);
        else if(type === 'lecture')
            $('#lectures-table-tr-'+id).empty().append(data);
    }).fail(function () {
        alert('Úprava predmetu nebola možná')
    });
}

function saveSchoolEvent(id, type, number) {
    var name = $('#edit-name-input').val();
    var date = $('#edit-date-input').val();
    $.ajax({
        url: 'assets/php/ajax/ajax_subjects.php',
        type: 'POST',
        data:
            {
                method: 'saveSchoolEvent',
                id: id,
                name: name,
                date: date,
                type: type,
                number: number,

            },
    }).done(function (data) {
        if(type === 'exercise')
            $('#exercises-table-tr-'+id).empty().append(data);
        else if(type === 'lecture')
            $('#lectures-table-tr-'+id).empty().append(data);
    }).fail(function () {
        alert('Uloženie predmetu nebola možná')
    });
}

function deleteSchoolEvent(id, type) {
    $.ajax({
        url: 'assets/php/ajax/ajax_subjects.php',
        type: 'POST',
        data:
            {

                method: 'deleteSchoolEvent',
                id: id,

            },
    }).done(function () {
        if(type === 'exercise')
            $('#exercises-table-tr-'+id).empty();
        else if(type === 'lecture')
            $('#lectures-table-tr-'+id).empty();
    }).fail(function () {
        alert('Vymazanie predmetu nebola možná')
    });


}


function editSubjectModal(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_subjects.php',
        type: 'POST',
        data:
            {

                method: 'editSubjectModal',
                id: id,

            },
    }).done(function (data) {
            $('#edit-modal-content').empty().append(data);
    }).fail(function () {
        alert('Vymazanie predmetu nebola možná')
    });
}

function createSET(id) {
    var assigment = $("#assigment-input").val();


    $.ajax({
        url: 'assets/php/ajax/ajax_schoolEvent.php',
        type: 'POST',
        data:
            {
                method: 'createSET',
                id: id,
                assigment: assigment,

            },
    }).done(function (data) {
        $("#school-event-tasks").append(data);
    }).fail(function () {
        alert('Uloženie predmetu nebola možná')
    });
}

function deleteSET(id) {

    $.ajax({
        url: 'assets/php/ajax/ajax_schoolEvent.php',
        type: 'POST',
        data:
            {
                method: 'deleteSET',
                id: id,

            },
    }).done(function () {
        $("#card-"+id).remove();
    }).fail(function () {
        alert('Uloženie predmetu nebola možná')
    });
}


function saveSETSolution(id) {
    var solution = $("#solution-textarea-"+id).val();
    //var res = solution.replace('\n', '<br>');

    $.ajax({
        url: 'assets/php/ajax/ajax_schoolEvent.php',
        type: 'POST',
        data:
            {
                method: 'saveSETSolution',
                id: id,
                solution: solution,

            },
    }).done(function (data, data2) {
        $("#set-msg-"+id).empty().append("<div class='alert-success'><p class='alert-success'>" + data + " Riešenie úspešne uložené</p></div>");
    }).fail(function () {
        alert('Uloženie predmetu nebola možná')
    });
}

function setAsSET(id, type) {


}

function setAsSET(id, type) {


}

function checkSET(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_schoolEvent.php',
        type: 'POST',
        data:
            {
                method: 'checkSET',
                id: id,

            },
    }).done(function (data) {
        if(data === 1)
            $("#check-icon-set-"+id).addClass('text-danger');
        else
            $("#check-icon-set-"+id).removeClass('text-danger');
    }).fail(function () {
        alert('Check on subject task has not been executed');
    });
}

function doneSET(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_schoolEvent.php',
        type: 'POST',
        data:
            {
                method: 'doneSET',
                id: id,

            },
    }).done(function (data) {
        if(data === "1")
            $("#done-icon-set-"+id).addClass("text-danger");
        else
            $("#done-icon-set-"+id).removeClass('text-danger');
    }).fail(function () {
        alert('Fail: Subject task has not been marked as done')
    });
}

