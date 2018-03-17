<?php
namespace App\Traits;

use SoapClient as Client;

trait ZohoTrait{

    protected function getEnv()
    {
        return [
            'authToken'        => env('ZOHO_AUTH_TOKEN'),
            'baseUrl'          => 'https://mail.zoho.com/api/organization/' . env('ZOHO_ORG_ID'),
            'adminPassword'    => env('ZOHO_ADMIN_PASSWORD')
        ];
    }

    protected function getZohoAccount(){
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
       /* phpinfo();exit;*/
        $env             = $this->getEnv();
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

        $client = new Client([
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Zoho-authtoken ' . $env['authToken']
            ]
        ]);
        try{
            $response = $client->request('POST', $env['baseUrl'] . '/accounts', [
                'form_params' => $defaultParams
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

    protected function updateZohoAccount( $params ){
        /*
         * "zuid": 663084666,
         * "accountId": "6301374000000008002",
         * we need to save those values so we can use that later to remove accounts.
         **/
        $env             = $this->getEnv();
        $defaultParams   = [
            "mode"                  => "disableUser", /*enableUser, resetPassword*/
            "zuid"                  => "", #
            "password"              => $env['adminPassword'],
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
            $response = $client->request('PUT', $env['baseUrl'] . '/accounts', [
                'form_params' => $defaultParams
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
            "password"              => $env['adminPassword']
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
                'form_params' => $defaultParams
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