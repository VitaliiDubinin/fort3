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
        // if(!empty($customer_list -> results)){
        //   return $customer_list->results;
        if(!empty($customer_list)){
          return $customer_list;
        } else {
        return  [1,2,3];
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
              // 'title'=>$card->title,
              // 'description'=>$card->overview,
              // 'movie_id'=>$card->id
              'title'=>$card->name,
              'description'=>$card->number,
              'movie_id'=>$card->owner,
            ];
            $requestCard[]=[
              '#theme'=>'severa-card',
              '#content'=>$content,
            ];          
          }
        }
        return $requestCard;
      }


}