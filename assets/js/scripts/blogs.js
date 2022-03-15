function createBlog(id) {
    var name = $('#name').val();
    var text = $('#text').val();
    var type = $('#type option:selected').val();
    var form_data = new FormData();
    files = document.getElementById('file').files;
    for(i=0; i<files.length; i++) {
        form_data.append('file[]', files[i]);
    }
    form_data.append('id_person', id);
    form_data.append('method', 'createBlog');
    form_data.append('name', name);
    form_data.append('text', text);
    form_data.append('type', type);

    $.ajax({
        type: 'POST',
        url: 'assets/php/ajax/ajax_blogs.php',
        contentType: false,
        processData: false,
        data: form_data,
        success:function(data) {
            $("#blogs").empty().append(data);
        },
        fail:function() {
            alert('Nepodarilo sa vytvoriť blog');
        }
    });

}

function deleteBlog(id) {
    $.ajax({
        url: 'assets/php/ajax/ajax_blogs.php',
        type: 'POST',
        data:
            {
                method: 'deleteBlog',
                id: id,
            },
    }).done(function () {
        $('#blog-' + id).remove();
    }).fail(function () {
        alert('Blog sa  nepodarilo vymazať');
    });
}