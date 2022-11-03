<?php

namespace Drupal\severa_directory\Controller;

use Drupal\Core\Controller\ControllerBase;

class SeveraRespond extends ControllerBase {
    public function view() 
    {
        $this->dataList();
        $content = [];
    
        $content['name'] = 'My name is Severa';
        $content['cards']=$this->requestCards();
    
        return [
          '#theme' => 'severa-respond',
          '#content' => $content,
        ];
    }

      public function dataList()
      {
        /** @var \Drupal\severa_directory\SeveraAPIConnector $severa_api_connector_service */
        $severa_api_connector_service = \Drupal::service('severa_directory.api_connector');

        $customer_list = $severa_api_connector_service->findCustomer();
        if(!empty($customer_list -> results)){
          return $customer_list->results;
        } else {
        return  [];
        }
      }



      public function requestCards()
      {
        $requestCard=[];
        $cards = $this->dataList();
        // dump($movies);
        if(!empty($cards))
        {
          foreach ($cards as $card)
          {
            $content =[
              'title'=>$card->title,
              'description'=>$card->overview,
              'movie_id'=>$card->id
            ];
            $requestCard[]=[
              '#theme'=>'movie-card',
              '#content'=>$content,
            ];          
          }
        }
        return $requestCard;
      }

      // public function createMovieCard(){
      //   $movieCards=[];
      //   $movies = [['title'=>'movie list is empty','overview'=>'movie list is empty','id'=>'11',],['title'=>'movie list is empty','overview'=>'movie list is empty','id'=>'12',]]; 
      //   if(!empty($movies)){
      //     foreach ($movies as $movie){
      //       $content =[
      //         'title'=>$movie['title'],
      //         'description'=>$movie['overview'],
      //         'movie_id'=>$movie['id'],
      //       ];
      //       $movieCards[]=[
      //         '#theme'=>'movie-card',
      //         '#content'=>$content,
      //       ];          
      //     }
      //   }
      //   return $movieCards;
      // }

      // public function createMovieCard(){
      //   $movieCards=[];
      //   $movies = [['title'=>'movie list is empty','overview'=>'movie list is empty','id'=>'11',],['title'=>'movie list is empty','overview'=>'movie list is empty','id'=>'12',]]; 
      //   if(!empty($movies)){
      //     foreach ($movies as $movie){
      //       $content =[
      //         'title'=>$movie['title'],
      //         'description'=>$movie['overview'],
      //         'movie_id'=>$movie['id'],
      //       ];
      //       $movieCards[]=[
      //         '#theme'=>'movie-card',
      //         '#content'=>$content,
      //       ];          
      //     }
      //   }
      //   return $movieCards;
      // }
}