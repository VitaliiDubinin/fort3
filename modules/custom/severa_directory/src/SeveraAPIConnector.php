<?php
namespace Drupal\severa_directory;

use Drupal\Core\Http\ClientFactory;
use Drupal\Core\Utility\Error;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
// use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use \Drupal\Component\Utility\UrlHelper;

use Drupal\Component\Serialization\Json;


class SeveraAPIConnector{
private $client;

private $query;



public function getRequestToken(){
    $client = new Client();
    $config = $this->config;

    $message="Expired authorization code";
    $url = 'https://api.severa.visma.com/rest-api/v1.0/token';

    $headers = [
      'Content-Type' => 'application/json',
    ];
    $body = [
        'client_Id' =>$config->get('client_id'),
        'client_Secret' => $config->get('client_secret'),
        'scope' => 'customers:read',
    ];




    $result = \Drupal::httpClient()->post($url, [
      'headers' => $headers,
      'body' => json_encode($body),
    ]);




    if ($result->getStatusCode() == 200) {
      $data = json_decode($result->getBody());
      $access_token = $data->access_token;
      return $access_token;
    } elseif ( $result->getStatusCode() === 400) { $data = json_decode($result->getBody());}
     else {
      return [$message];
    }

  }





public function findCustomer(){

    $resofrequesttoken = $this->getRequestToken();

    $data =[];
    $auth = 'Bearer ' . $resofrequesttoken; 

    try {

        $client = new Client();
        $headers = [
            'client_id' => 'DruidOy_ofoRepCSMeeUd7M2nY.apps.vismasevera.com',
            'Authorization' => $auth,

          ];

        $request = new Request('GET', 'https://api.severa.visma.com/rest-api/v1/customers', $headers);
        $res = $client->sendAsync($request)->wait();  


        $result = $res->getBody()->getContents();
        $data =json_decode($result);
    }
    catch(RequestException $e){
        $variables = Error::decodeException($e);
        \Drupal::logger('severa-directory')->error('%type: @message in %function (line %line of %file).', $variables);     
    }

    return $data;
  }

}