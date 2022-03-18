

function createSchool() {
    const name = $('#name-input').val();
    const start = $('#start-input').val();
    const end = $('#end-input').val();
    if (!name || !start) {
        $('#msg-submit').empty().append("<div class='alert alert-danger' role='alert'>" +
            "<strong>Something went wrong!</strong> Change something and try it again! </div>");
        return;
    }
    $.ajax({
        url: 'assets/php/ajax/ajax_schools.php',
        type: 'POST',
        data:
            {
                method: 'createSchool',
                name: name,
                start: start,
                end: end,

            },
    }).done(function (data) {
        $('#schools-list-tbody').append(data);
    }).fail(function () {
        alert('Fail: School has not been created');
    });
}