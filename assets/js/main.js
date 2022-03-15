(function ($) {

    "use strict";

    $(window).on('load', function () {

        /* Page Loader active
        ========================================================*/
        $('#preloader').fadeOut();

        $('[data-toggle="tooltip"]').tooltip()

        $('[data-toggle="popover"]').popover()

    });




}(jQuery));

jQuery.browser = {};
(function () {
    jQuery.browser.msie = false;
    jQuery.browser.version = 0;
    if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
        jQuery.browser.msie = true;
        jQuery.browser.version = RegExp.$1;
    }
})();


document.addEventListener("DOMContentLoaded", function () {
    var elements = document.getElementsByTagName("INPUT");
    for (var i = 0; i < elements.length; i++) {
        elements[i].oninvalid = function (e) {
            e.target.setCustomValidity("");
            if (!e.target.validity.valid) {
                e.target.setCustomValidity("Toto pole nemôže ostať prázdne");
            }
        };
        elements[i].oninput = function (e) {
            e.target.setCustomValidity("");
        };
    }
})



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

function submitMSG(valid, msg) {
    if (valid) {
        var msgClasses = "h3 text-left tada animated text-success";
    } else {
        var msgClasses = "h3 text-left text-danger";
    }
    $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
}


var fileobj;

function upload_file_table(e, table, id_connect) {
    e.preventDefault();
    ajax_file_upload(e.dataTransfer.files, table, id_connect);
}

function file_explorer_table(table, id_connect) {
    var name = name;
    document.getElementById('selectfile-'+table).click();
    document.getElementById('selectfile-'+table).onchange = function () {
        files = document.getElementById('selectfile-'+table).files;
        ajax_file_upload_table(files, table, id_connect);
    };
}

function ajax_file_upload_table(file_obj, table, id) {
    var form_data = new FormData();
    for (i = 0; i < file_obj.length; i++) {
        form_data.append('file[]', file_obj[i]);
    }
    form_data.append('id', id);
    form_data.append('table', table);
    form_data.append('method', 'addFile');
    $.ajax({
        type: 'POST',
        url: 'assets/php/ajax/ajax.php',
        contentType: false,
        processData: false,
        data: form_data,
        success: function (data) {
            $('#files-'+table).append(data);
        },
        fail: function () {
            alert('Nepodarilo sa nahrať fotografiu');
        }
    });
}

function isValidDate(date) {
    var temp = date.split('-');
    var d = new Date(temp[0] + '-' + temp[1] + '-' + temp[2]);
    return (d && (d.getMonth() + 1) == temp[1] && d.getDate() == Number(temp[2]) && d.getFullYear() == Number(temp[0]));
}

function createHref(id, table) {
    $.ajax({
        url: 'assets/php/ajax/ajax.php',
        type: 'POST',
        data:
            {

                method: 'createLink',
                id: id,
                table: table,
                name: $('#name-link-input').val(),
                link: $('#link-input').val(),
                type:$('#type-link-input').val(),
            },
    }).done(function (data) {
        $('#links').empty().append(data);
    }).fail(function () {
        alert('Vytvorenie odkazu sa nepodarilo')
    });
}


function deleteLink(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax.php',
        type: 'POST',
        data:
            {

                method: 'deleteLink',
                id: id,
            },
    }).done(function (data) {
        $('#links').empty().append(data);
    }).fail(function () {
        alert('Vytvorenie odkazu sa nepodarilo')
    });
}

function regUser() {
    $.ajax({
        url: 'assets/php/server.php',
        type: 'POST',
        data:
            {

                method: 'reg',
                email: $('#email-input').val(),
                name: $('#name-input').val(),
                second_name: $('#second-name-input').val(),
                password1: $('#password-input').val(),
                password2: $('#password2-input').val(),
                username: $('#username-input').val(),
                accept: $('#accept-condition-input').val(),
            },
    }).done(function (data) {
        $('#errors-div').empty().append(data);
        alert('reg-done');
    }).fail(function (ts) {
        alert('Fail: Registration of user has failed:' +ts.text)

    });
}

