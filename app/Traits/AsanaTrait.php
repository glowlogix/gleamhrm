<?php
namespace App\Traits;

use GuzzleHttp\Client as Client;
use GuzzleHttp\Psr7\Request;
trait AsanaTrait{

    protected function getEnv()
    {
        return [
            'asanaToken' => config('values.asanaToken')
        ];
    }
    protected function addUserToTeam(array $teams,$email){
                //token and the email of the employee is get
                foreach($teams as $key =>$val){
                    $url = 'https://app.asana.com/api/1.0/teams/'.$teams[$key].'/addUser';
                    
                    $client = new Client(
                        [
                           'headers' => [
                               'Authorization' => 'Bearer'.$env['asanaToken']
                           ]
                       ]);
                   try{
                    $response = $client->request('POST',$url,[
                        
                    'form_params'=> [
                        'user' => $email
                    ]
                    
                    ]);
                       
                } catch (RequestException $e) {
                    return $e->getMessage();
                }
                if ( $response->getStatusCode() == 200) {
                    $data = json_decode( $response->getBody()->getContents(),true);
                    
                }else{
                    $data = json_decode( $response->getBody() );
                }
                return response()->json( $data, 200 );
                
            }            

    }


}