<?php ob_start(); ?>

<div class="row">
    <div class="col-md-4 offset-md-8">
        <form method="get">
            <div class="form-group has-btn">
                <input type="search" id="search" name="title" value="<?= $search; ?>" class="form-control"
                       placeholder="Rechercher un film ou une série">

                <button type="submit" class="btn btn-block bg-red">Valider</button>
            </div>
        </form>
    </div>
</div>

<div class="media-list d-flex flex-column">
    <div class="row">
        <?php if (!isset($_GET['title']) || empty($_GET['title']) ){
        //var_dump($movies);
            foreach( $movies as $movie ): ?>
                <a class="item" href="index.php?movie=<?= $movie['id']; ?>">
                    <div class="video">
                        <div>
                            <iframe allowfullscreen="" frameborder="0"
                                    src="<?= $movie['trailer_url']; ?>" ></iframe>
                        </div>
                    </div>
                    <div class="title"><?= $movie['title']; ?></div>
                </a>
            <?php endforeach; ?>
    </div>
    <?php } else {
        foreach( $mediasSearch as $media ): ?>
    <a class="item" href="index.php?serie=<?= $media['id']; ?>">
        <div class="video">
            <div>
                <iframe allowfullscreen="" frameborder="0"
                        src="<?= $media['trailer_url']; ?>" ></iframe>
            </div>
        </div>
        <div class="title"><?= $media['title']; ?></div>
    </a>
    <?php endforeach; } ?>
</div>


<?php $content = ob_get_clean(); ?>

<?php require('dashboard.php'); ?>
