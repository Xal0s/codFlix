<?php

require_once( 'model/media.php' );

/***************************
* ----- LOAD HOME PAGE -----
***************************/

//all movies are displayed

function allMoviesPage() {

    $search = $_GET['title'] ?? null;
    $mediasSearch = Media::filterMovies( $search );
    $movies = Media::getAllMovies();
    require('view/movieListView.php');

}

/***************************
 * ---- LOAD MOVIE PAGE----*
 ***************************/
//one movie with details is displayed
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

//display all series
function allSeriesPage(){

    $search = $_GET['title'] ?? null;
    $mediasSearch = Media::filterSeries($search);
    $series = Media::getAllSeries();
    require('view/seriesListView.php');
}
//display one serie with details and its seasons
function seriePage(){
    try {
        if ($_GET['serie']) {
            $mediaId = $_GET['serie'];
            $serie = Media::getSerie($mediaId);
            $i=0;
            $seasons = Media::getSeasons($mediaId);
            $episodes = Media::getAllEpisodes($mediaId);
            require('view/serieView.php');
        }else{
            throw new Exception("La série n'existe pas");
        }
    }catch (Exception $e) {
        echo $e->getMessage();
    }
}


