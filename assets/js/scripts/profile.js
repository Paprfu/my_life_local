
function file_explorer(id, method) {
    var name = name;
    document.getElementById('selectfile').click();
    document.getElementById('selectfile').onchange = function() {
        files = document.getElementById('selectfile').files;
        ajax_file_upload(files, id,method);
    };
}

function ajax_file_upload(file_obj,id,method) {
    var form_data = new FormData();
    for(i=0; i<file_obj.length; i++) {
        form_data.append('file[]', file_obj[i]);
    }
    form_data.append('id', id);
    form_data.append('method', method);
    $.ajax({
        type: 'POST',
        url: 'assets/php/ajax/ajax_profile.php',
        contentType: false,
        processData: false,
        data: form_data,
        success:function(data) {
            if(method === 'addPhoto')
            $("#photo").empty().append(data);
            if(method === 'addTitlePhoto')
            $("#title-photo").empty().append(data);
            $('#selectfile').val('');
        },
        fail:function() {
            alert('Nepodarilo sa nahrať fotografiu');
        }
    });
}

function editProfile(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_profile.php',
        type: 'POST',
        data:
            {
                method: 'edit',
                id: id,
            },
    }).done(function (data) {
        $('#profile-info-div').empty().append(data);
    }).fail(function () {
        alert('Projekt sa nedal vytvoriť');
    });


}

function saveProfile(id) {
    var name = $('#name-input').val();
    var second_name = $('#second-name-input').val();
    var description = $('#description-textarea').val();
    $.ajax({
        url: 'assets/php/ajax/ajax_profile.php',
        type: 'POST',
        data:
            {
                method: 'save',
                id: id,
                name: name,
                second_name: second_name,
                description: description,
            },
    }).done(function (data) {
        $('#profile-info-div').empty().append(data);
    }).fail(function () {
        alert('Projekt sa nedal vytvoriť');
    });
}

function createTimeline() {
    $.ajax({
        url: 'assets/php/ajax/ajax_profile.php',
        type: 'POST',
        data:
            {
                method: 'createTimeline',

                text: $('#timeline-textarea').val(),
            },
    }).done(function (data) {
        $('#timeline').append(data);
    }).fail(function () {
        alert('Nedalo sa pridať na timeline');
    });
}

function selectPhotoToTimeline() {
    document.getElementById('select-timeline-photo-input').click();
    document.getElementById('select-timeline-photo-input').onchange = function() {
        let files = document.getElementById('select-timeline-photo-input').files;
        var form_data = new FormData();
        for(i=0; i<files.length; i++) {
            form_data.append('file[]', files[i]);
        }
        form_data.append('method', "selectPhotosOnTimeline");
        $.ajax({
            type: 'POST',
            url: 'assets/php/ajax/ajax_profile.php',
            contentType: false,
            processData: false,
            data: form_data,
            success:function(data) {
                $('#timeline-selected-photos').empty().append(data);
                alert('success');
            },
            fail:function(ts) {
                alert('Fail: Has not been able to upload photos on timeline' + ts.text);
            }
        });
    };
}

function selectFileToTimeline() {

}

function selectPlaceToTimeline() {

}
