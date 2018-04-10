<?php
namespace App\Traits;
use GuzzleHttp\Client as Client;
use GuzzleHttp\Psr7\Request;

trait ZohoTrait{

    protected function getEnv()
    {
        return [
            'authToken'        => config('values.zohoToken'),
            'baseUrl'          => 'https://mail.zoho.com/api/organization/'.config('values.zohoOrgId'),
            'accountId' => '6321206000000008002'
        ];
    }
    
    protected function countUsersInOrg(){
        $env  = $this->getEnv();        
        $url = 'http://mail.zoho.com/api/organization/'.config('values.zohoOrgId');
        $client = new Client(
            [
               'headers' => [
                   'Accept'        => 'application/json',
                   'Authorization' => 'Zoho-authtoken ' . $env['authToken']
               ]
           ]);
           try{
               $response = $client->request('GET',$url);
               $data = json_decode($response->getBody());
               $mailBoxCount = $data->data->usersCount; //USers count in org
               return $mailBoxCount;
           } catch (RequestException $e) {
               return $e->getMessage();
           }
           
    }


    protected function getZohoAccount(){
        $limit = $this->countUsersInOrg();
        $env  = $this->getEnv();        
        $url = 'http://mail.zoho.com/api/organization/'.config('values.zohoOrgId').'/accounts';
        $client = new Client(
            [
               'headers' => [
                   'Accept'        => 'application/json',
                   'Authorization' => 'Zoho-authtoken ' . $env['authToken']
               ]
           ]);
           try{
               $response = $client->request('GET',$url,[
                   'query' => [
                       'limit' => $limit
                   ]
               ]);
            $data = json_decode( $response->getBody()->getContents());
            return $data;
           } catch (RequestException $e) {
               return $e->getMessage();
           }
           
           
   
    }

    /**
     * Create Zoho account.
     *
     * @param $params
     * @return \Illuminate\Http\JsonResponse|string
     */
    protected function createZohoAccount( $params ){
        /*
         * "zuid": 663084666,
         * "accountId": "6301374000000008002",
         * we need to save those values so we can use that later to remove accounts.
         * */
        $env  = $this->getEnv();

        $defaultParams   = [
            "role"                  => "member",
            "emailAddress"          => "",
            "primaryEmailAddress"   => "",
            "timeZone"              => "Asia/Karachi",
            "language"              => "En",
            "displayName"           => "",
            "password"              => "",
            "userExist"             => false,
            "country"               => "pk"
        ];
        $defaultParams = array_merge( $defaultParams, $params );
        $client = new Client(
         [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Zoho-authtoken ' . $env['authToken']
            ]
        ]);
        try{
            $response = $client->request('POST', $env['baseUrl'] . '/accounts', [
                'json' => $defaultParams
            ]);
        } catch (RequestException $e) {
            return $e->getMessage();
        }

        if ( $response->getStatusCode() == 200) {
            $data = json_decode( $response->getBody()->getContents());
        }else{
            $data = json_decode( $response->getBody()->getContents() );
        }
        return response()->json( $data, 200 );
    }

    protected function updateZohoAccount( $params ){
       
        /*
         * "zuid": 663084666,
         * "accountId": "6301374000000008002",
         * we need to save those values so we can use that later to remove accounts.
         **/
        $env             = $this->getEnv();
        $defaultParams   = [
            "mode"                  => "disableUser", /*enableUser*/
            "zuid"                  => "", #
            "password"              => "",
            //"resetAuthtoken"        => true
        ];
        $defaultParams = array_merge( $defaultParams, $params );
        $client = new Client([
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Zoho-authtoken ' . $env['authToken']
            ]
        ]);
        try{
            $response = $client->request('PUT', $env['baseUrl'] . '/accounts'.'/'.$env['accountId'], [
                'json' => $defaultParams
            ]);
        } catch (RequestException $e) {
            return $e->getMessage();
        }

        if ( $response->getStatusCode() == 200) {
            $data = json_decode( $response->getBody() );
        }else{
            $data = json_decode( $response->getBody() );
        }
        return response()->json( $data, 200 );
    }

    protected function deleteZohoAccount( $params ){
        /*
         * "zuid": 663084666,
         * "accountId": "6301374000000008002",
         * we need to save those values so we can use that later to remove accounts.
         **/
        $env             = $this->getEnv();
        $defaultParams   = [
            "mode"                  => "deleteUser",
            "zuid"                  => "", #
            "password"              => ""
        ];
        $defaultParams = array_merge( $defaultParams, $params );

        $client = new Client([
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Zoho-authtoken ' . $env['authToken']
            ]
        ]);
        try{
            $response = $client->request('DELETE', $env['baseUrl'] . '/accounts', [
                'query' => $defaultParams
            ]);
        } catch (RequestException $e) {
            return $e->getMessage();
        }

        if ( $response->getStatusCode() == 200) {
            $data = json_decode( $response->getBody() );
        }else{
            $data = json_decode( $response->getBody() );
        }
        return response()->json( $data, 200 );
    }
}