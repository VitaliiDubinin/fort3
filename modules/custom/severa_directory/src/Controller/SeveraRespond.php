<?php

namespace Drupal\severa_directory\Controller;

use Drupal\Core\Controller\ControllerBase;

class SeveraRespond extends ControllerBase {
    public function view() {
        $this->listMovies();
        $content = [];
    
        $content['name'] = 'My name is Severa';
        $content['movies']=$this->createMovieCard();
    
        return [
          '#theme' => 'severa-respond',
          '#content' => $content,
        ];
      }

      public function listMovies(){
        /** @var \Drupal\severa_directory\MovieAPIConnector $severa_api_connector_service */
        $severa_api_connector_service = \Drupal::service('severa_directory.api_connector');
        $movie_list = $severa_api_connector_service->discoverMovies();
        if(!empty($movie_list -> results)){
          return $movie_list->results;
        } else {
        return  [
          ['#title' => $this->t('API Key (v3 auth)')],
          ['#title' =>'movie list is empty'],
          '#id' => 11];}
      }

      public function createMovieCard(){
        $movieCards=[];
        $movies = $this->listMovies();
        if(!empty($movies)){
          foreach ($movies as $movie){
            $content =[
              'title'=>$movie->title,
              'description'=>$movie->overview,
              'movie_id'=>$movie->id
            ];
            $movieCards[]=[
              '#theme'=>'movie-card',
              '#content'=>$content,
            ];          
          }
        }
        return $movieCards;


      }

}