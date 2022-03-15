function project(method) {
    $.ajax({
        url: 'assets/php/ajax/ajax_projects.php',
        type: 'POST',
        data:
            {
                method: method,
                type: $('#projects-time-select option:selected').val(),
            },
    }).done(function (data) {
        $('#projects-tbody').empty().append(data);
    }).fail(function (ts) {
        alert('Fail: Working time on project has not been shown ' +ts.text);
    });
}
