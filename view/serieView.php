<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php ob_start(); ?>
<div class="container">
    <div class="row">
        <div class ="movie-genre">
            <h1 class="movie-title"><?= $serie['title'] ?></h1>
            <em class="movie-genre"><strong><?= $serie['name'] ?></strong></em>
        </div>
        <div class="d-flex row">
            <div class="embed-responsive embed-responsive-16by9 video-container">
                <iframe class="embed-responsive-item" src="<?= $serie['trailer_url'] ?>" allowfullscreen></iframe>
            </div>
            <div class="episodes col-6  d-flex p-2 justify-content-center">
                <?php foreach ($seasons as $season) {
                    $i ++ ?>
                    <div class="row-4 m-3">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $i ?>" class="btn btn-danger">Saison <?= $i ?></button>
                        <div class="modal fade" id="exampleModal<?= $i ?>" tabindex="-1" aria-labelledby="exampleModalLabel<?= $i ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel<?= $i ?>">Saison <?= $i ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php foreach ($episodes as $episode){
                                            if ($episode['seasonNbr'] == $season['seasonNbr']){ ?>
                                                <div class="video-frame d-flex row justify-content-center pb-5">
                                                    <h6><?=$episode['episodeNum'] ?>.  <?= $episode['episodeName'] ?></h6>
                                                    <iframe src="<?= $episode['episodeLink'] ?>" frameborder="0"></iframe>
                                                    <p><?= $episode['synopsis'] ?></p>
                                                    <em><?= $episode['duration'] ?></em>
                                                </div>
                                            <?php }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="synopsis row">
                <h6><Strong>Synopsis : </Strong></h6>
                <p><?= $serie['summary'] ?></p>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('dashboard.php'); ?>

