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

// public function __construct(ClientFactory $client){
//     // $client = new Client();
 
//     $movie_api_config = \Drupal::state()->get(\Drupal\severa_directory\Form\MovieAPI::MOVIE_API_CONFIG_PAGE);
//     // $api_url=($movie_api_config['api_base_url'])?: 'https://api.themoviedb.org';
//     // $api_key=($movie_api_config['api_key'])?:'8804da8efecd504320eb35f0438ea339';
//     // $api_url='https://api.themoviedb.org';
//     // $api_key='8804da8efecd504320eb35f0438ea339';
//     $api_url='https://api.severa.visma.com';
//     $api_key='';

//     $query=['api_key'=>$api_key];
//     $this->query=$query;
//     $this->client = $client->fromOptions(
//         [
//             'base_url'=>$api_url,
//             'query'=>$query
//         ]
//     );

// }

public function getRequestToken(){
    $client = new Client();

    $message="Expired authorization code";
    // $config = $this->config;
    $url = 'https://api.severa.visma.com/rest-api/v1.0/token';

    $headers = [
      'Content-Type' => 'application/json',
        //       'client_Id' =>'DruidOy_ofoRepCSMeeUd7M2nY.apps.vismasevera.com',
        // 'client_Secret' => 'bc0f05f6-1596-4371-314f-c470d7b7fa1c',
        // 'scope' => 'customers:read',
    ];
    $body = [
        'client_Id' =>'DruidOy_ofoRepCSMeeUd7M2nY.apps.vismasevera.com',
        'client_Secret' => 'bc0f05f6-1596-4371-314f-c470d7b7fa1c',
        'scope' => 'customers:read',
    ];

    // $body = urldecode(UrlHelper::buildQuery([
    // //   'client_Id' => $config->get('DruidOy_ofoRepCSMeeUd7M2nY.apps.vismasevera.com'),
    // //   'client_Secret' => $config->get('client_secret'),
    // //   'scope' => $config->get('customers:read'),
    //   'client_Id' =>'DruidOy_ofoRepCSMeeUd7M2nY.apps.vismasevera.com',
    //   'client_Secret' => 'bc0f05f6-1596-4371-314f-c470d7b7fa1c',
    //   'scope' => 'customers:read',
    // ]));


    $result = \Drupal::httpClient()->post($url, [
      'headers' => $headers,
      'body' => json_encode($body),
    ]);


    // $request = new Request('POST', 'https://api.severa.visma.com/rest-api/v1.0/token', $headers, json_encode($body));
    // $res = $client->sendAsync($request)->wait();  




    // $result = [
    //   'headers' => $headers,
    //   'body' => $data,
    // ];

    if ($result->getStatusCode() == 200) {
      $data = json_decode($result->getBody());
      $access_token = $data->access_token;
      return $access_token;
    } elseif ( $result->getStatusCode() === 400) { $data = json_decode($result->getBody());}
     else {
      return [$message];
    }
    // return $data;
    // return $request;
    // return $result;
    // return dump ($res);
  }





public function findCustomer(){

    $resofrequesttoken = $this->getRequestToken();

    $data =[];
    // $endpoint ='/3/discover/movie';
    // $options=['query'=> $this->query];
    $auth = 'Bearer ' . $resofrequesttoken; 

    try {

        $client = new Client();
        $headers = [
            'client_id' => 'DruidOy_ofoRepCSMeeUd7M2nY.apps.vismasevera.com',
            'Authorization' => $auth,
            // 'Authorization' => 'Bearer eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJjbGllbnRzdWIiOjU0MDk1NywiY2xpZW50b3JnIjo0MTQ1NCwiY2xpZW50ZGIiOjYsImNsaWVudGlkIjoiRHJ1aWRPeV9vZm9SZXBDU01lZVVkN00yblkuYXBwcy52aXNtYXNldmVyYS5jb20iLCJzY29wZSI6IjAwMDEwMDAwMDAwMDAwMDAiLCJleHAiOjE2Njc1NTg4MzYsImlzcyI6IlNldmVyYV9QdWJsaWNSZXN0X0FQSSIsImlhdCI6MTY2NzU1NTIzNiwibmJmIjoxNjY3NTU1MjM2fQ.ERHf9gh9_Pbkv1ZlKdaJ6PfFMZyc9TRxVjrJle5ApMF0nxxs0fvdLHTXAKVuK8WikujBiPahpUzCDJlOQ3vaww'
          ];

        $request = new Request('GET', 'https://api.severa.visma.com/rest-api/v1/customers', $headers);
        $res = $client->sendAsync($request)->wait();  

        // $request = $this->client->get('https://api.themoviedb.org/3/discover/movie?api_key=8804da8efecd504320eb35f0438ea339');
        // $request = $this->client->get('https://api.severa.visma.com/rest-api/v1.0/customers');
        // $request = $this->client->get('https://api.severa.visma.com/rest-api/v1.0/customers');
        
        // $client = \Drupal::httpClient();
        // $ressevera =$client->request('GET', 'https://api.severa.visma.com/rest-api/v1.0/customers');

   
        // $resgoogle = $client->request('GET', 'https://www.google.com');

        // $result = $resgoogle->getBody()->getContents();
        // $result = $ressevera->getBody()->getContents();
        $result = $res->getBody()->getContents();
        $data =json_decode($result);
    }
    catch(RequestException $e){
        $variables = Error::decodeException($e);
        \Drupal::logger('severa-directory')->error('%type: @message in %function (line %line of %file).', $variables);     
    }
    // return dump($this->client,$resgoogle,$result,$data);
    // return dump($this->client,$ressevera,$result,$data);
    // return dump($this->client,$res,$result,$data);
    // return dump($this->client,$endpoint,$options,$request,$result,$data);
    // return dump($client,$endpoint,$options,$request,$result,$data,$resgoogle);
    // return dump($resofrequesttoken);
    return $data;
  }

}