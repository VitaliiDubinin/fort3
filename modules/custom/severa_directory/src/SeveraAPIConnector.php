<?php
namespace Drupal\severa_directory;

use Drupal\Core\Http\ClientFactory;
use Drupal\Core\Utility\Error;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

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

public function findCustomer(){
    $data =[];
    // $endpoint ='/3/discover/movie';
    // $options=['query'=> $this->query];

    try {

        $client = new Client();
        $headers = [
            'client_id' => 'DruidOy_ofoRepCSMeeUd7M2nY.apps.vismasevera.com',
            'Authorization' => 'Bearer eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJjbGllbnRzdWIiOjU0MDk1NywiY2xpZW50b3JnIjo0MTQ1NCwiY2xpZW50ZGIiOjYsImNsaWVudGlkIjoiRHJ1aWRPeV9vZm9SZXBDU01lZVVkN00yblkuYXBwcy52aXNtYXNldmVyYS5jb20iLCJzY29wZSI6IjAwMDEwMDAwMDAwMDAwMDAiLCJleHAiOjE2Njc0ODE1NjksImlzcyI6IlNldmVyYV9QdWJsaWNSZXN0X0FQSSIsImlhdCI6MTY2NzQ3Nzk2OSwibmJmIjoxNjY3NDc3OTY5fQ.4EuonxRWQrfAoodkJ9o-jCUwqkLPFyrZ2AMKczCCRncg-p3o8QyBxSUDNYumnYdcxTXfiHLBQYIgsOkWZuPT1Q'
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
    return $data;
  }

}