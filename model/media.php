<?php

require_once( 'database.php' );

class Media {

    protected $id;
    protected $genre_id;
    protected $title;
    protected $type;
    protected $status;
    protected $release_date;
    protected $summary;
    protected $trailer_url;

    public function __construct( $media ) {

        $this->setId( isset( $media->id ) ? $media->id : null );
        $this->setGenreId( $media->genre_id );
        $this->setTitle( $media->title );
    }

    /***************************
    * -------- SETTERS ---------
    ***************************/

    public function setId( $id ) {
        $this->id = $id;
    }

    public function setGenreId( $genre_id ) {
        $this->genre_id = $genre_id;
    }

    public function setTitle( $title ) {
        $this->title = $title;
    }

    public function setType( $type ) {
        $this->type = $type;
    }

    public function setStatus( $status ) {
        $this->status = $status;
    }

    public function setReleaseDate( $release_date ) {
        $this->release_date = $release_date;
    }

    /***************************
    * -------- GETTERS ---------
    ***************************/

    public function getId() {
        return $this->id;
    }

    public function getGenreId() {
        return $this->genre_id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getType() {
        return $this->type;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getReleaseDate() {
        return $this->release_date;
    }

    public function getSummary() {
        return $this->summary;
    }

    public function getTrailerUrl() {
        return $this->trailer_url;
    }

    /***************************
    * -------- GET LIST --------
    ***************************/

    public static function filterMovies($title) {
        // Open database connection
        $db   = init_db();

        $req  = $db->prepare( "SELECT * FROM medias WHERE LOWER(title) LIKE ? AND type = 'film'" );
        $req->execute( array( '%' . strtolower($title) . '%' ));

        // Close databse connection
        $db   = null;

        return $req->fetchAll();

    }

    public static function filterSeries($title) {
        // Open database connection
        $db   = init_db();

        $req  = $db->prepare( "SELECT * FROM medias WHERE LOWER(title) LIKE ? AND type = 'serie'" );
        $req->execute( array( '%' . strtolower($title) . '%' ));

        // Close databse connection
        $db   = null;

        return $req->fetchAll();

    }
    public static function getAllMovies() {
        $db   = init_db();
        $req  = $db->prepare( "SELECT * FROM medias INNER JOIN genre ON medias.genre_id = genre.id WHERE type = 'film'");
        $req->execute();
        $db   = null;

        return $req->fetchAll();
    }

    public static function getMovie($id) {
        $db   = init_db();
        $req  = $db->prepare( "SELECT * FROM medias  
        INNER JOIN genre ON medias.genre_id = genre.id
        WHERE medias.id = ? AND type = 'film'");
        $req->execute([$id]);

        $db   = null;
        return $req->fetch();
    }

    public static function getAllSeries(){
        $db   = init_db();
        $req = $db->prepare( "SELECT * FROM medias WHERE type = 'serie'");
        $req->execute();

        $db = null;

        return $req->fetchAll();
    }

    public static function getSerie($id) {
        $db   = init_db();
        $req  = $db->prepare( "SELECT * FROM medias  
        INNER JOIN genre ON medias.genre_id = genre.id
        WHERE medias.id = ? AND medias.type = 'serie'");
        $req->execute([$id]);

        $db   = null;
        return $req->fetch();
    }

    public static function getSeasons($serie){
        $db   = init_db();
        $req  = $db->prepare( "SELECT season_num AS seasonNbr FROM seasons
        INNER JOIN medias ON medias.id = seasons.serie_id
        WHERE seasons.serie_id = ? GROUP BY seasonNbr ");
        $req->execute([$serie]);

        $db   = null;
        return $req->fetchAll();
    }

    public static function getAllEpisodes($serie){
        $db   = init_db();
        $req  = $db->prepare( "SELECT episode_num AS episodeNum, episode_url AS episodeLink, episodes.name AS episodeName, seasons.season_num AS seasonNbr, episodes.duration AS duration, medias.summary AS synopsis FROM episodes 
        INNER JOIN seasons ON episodes.id = seasons.episode_id
        INNER JOIN medias ON medias.id = seasons.serie_id  WHERE seasons.serie_id = ?");
        $req->execute([$serie]);

        $db   = null;
        return $req->fetchAll();
    }
}
