<?php

require_once( 'model/media.php' );

/***************************
* ----- LOAD HOME PAGE -----
***************************/

function allMoviesPage() {

  $search = $_GET['title'] ?? null;
  $mediasSearch = Media::filterMedias( $search );
  $movies = Media::getAllMovies();
  require('view/movieListView.php');

}

/***************************
 * ---- LOAD MOVIE PAGE----*
 ***************************/

function moviePage(){
    try {
        if (isset($_GET['movie'])) {
            $mediaId = $_GET['movie'];
            $movie = Media::getMovie($mediaId);
            require('view/movieView.php');
        } else {
            throw new Exception('Une erreur est survenue');
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function allSeriesPage(){
    $search = $_GET['title'] ?? null;
    $mediasSearch = Media::filterMedias( $search );
    $series = Media::getAllSeries();
    require('view/seriesListView.php');
}

function seriePage(){
    try {
        if ($_GET['serie']) {
            $mediaId = $_GET['serie'];
            $serie = Media::getSerie($mediaId);
            require('view/serieView.php');
        }else{
            throw new Exception("La série n'existe pas");
        }
    }catch (Exception $e) {
        echo $e->getMessage();
    }
}


