<?php

require_once( 'model/media.php' );

/***************************
* ----- LOAD HOME PAGE -----
***************************/

function mediaPage() {

  $search = $_GET['title'] ?? null;
  $mediasSearch = Media::filterMedias( $search );
  $movies = Media::getAllMovies();
  require('view/mediaListView.php');

}

