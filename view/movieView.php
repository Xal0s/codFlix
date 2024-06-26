<link rel="stylesheet" href="/public/css/layout/pages/media.css">
<?php ob_start(); ?>

<div class ="movie-genre">
    <h1 class="movie-title"><?= $movie['title'] ?></h1>
    <em class="movie-genre"><strong><?= $movie['name'] ?></strong></em>
</div>
<div class="d-flex row justify-content-sm-center">
    <div class="embed-responsive embed-responsive-16by9 video-container">
        <iframe class="embed-responsive-item" src="<?= $movie['trailer_url'] ?>" allowfullscreen></iframe>
    </div>
    <div class="synopsis">
        <h6><Strong>Synopsis : </Strong></h6>
        <p><?= $movie['summary'] ?></p>
    </div>
</div>



<?php $content = ob_get_clean(); ?>
<?php require('dashboard.php'); ?>


