<?php if (count($errors) > 0) : ?>
    <div id="errors" class="alert alert-danger" role="alert">
        <?php foreach ($errors as $error) :
            echo $error;
        endforeach ?>
    </div>
<?php endif ?>
