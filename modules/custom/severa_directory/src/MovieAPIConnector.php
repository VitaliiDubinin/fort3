<?php
namespace Drupal\severa_directory;

use Drupal\Core\Http\ClientFactory;
use Drupal\Core\Utility\Error;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Drupal\Component\Serialization\Json;


class MovieAPIConnector{
private $client;

private $query;

public function __construct(ClientFactory $client){
    // $client = new Client();
 
    $movie_api_config = \Drupal::state()->get(\Drupal\severa_directory\Form\MovieAPI::MOVIE_API_CONFIG_PAGE);
    // $api_url=($movie_api_config['api_base_url'])?: 'https://api.themoviedb.org';
    // $api_key=($movie_api_config['api_key'])?:'8804da8efecd504320eb35f0438ea339';
    $api_url='https://api.themoviedb.org';
    $api_key='8804da8efecd504320eb35f0438ea339';

    $query=['api_key'=>$api_key];
    $this->query=$query;
    $this->client = $client->fromOptions(
        [
            'base_url'=>$api_url,
            'query'=>$query
        ]
    );

}

public function discoverMovies(){
    $data =[];
    $endpoint ='/3/discover/movie';
    $options=['query'=> $this->query];
    // $client = new Client();
    // $client = \Drupal::httpClient();
    // $result = $client->request('GET', 'https://www.google.com');

    // $client = \Drupal::httpClient();
    // $request = $this->client->get($endpoint, $options);
    try {
        // $client = \Drupal::httpClient();
        // $resgoogle = $client->request('GET', 'https://www.google.com');
        // $request = $this->client->get($endpoint, $options);
        $request = $this->client->get('https://api.themoviedb.org/3/discover/movie?api_key=8804da8efecd504320eb35f0438ea339');
        // $request = $client->get($endpoint, $options);
        // $request= $client->request('GET', 'https://api.themoviedb.org/3/discover/movie?api_key=8804da8efecd504320eb35f0438ea339');
        // $request=$this->request;
        $result = $request->getBody()->getContents();
        $data =json_decode($result);
    }
    catch(RequestException $e){
        $variables = Error::decodeException($e);
        \Drupal::logger('severa-directory')->error('%type: @message in %function (line %line of %file).', $variables);     
    }
    // return dump($this->client,$endpoint,$options,$request,$result,$data);
    // return dump($client,$endpoint,$options,$request,$result,$data,$resgoogle);
    return $data;
  }

}