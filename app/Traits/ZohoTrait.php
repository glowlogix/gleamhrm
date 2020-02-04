<?php

namespace App\Traits;

use GuzzleHttp\Client as Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

// use GuzzleHttp\Exception\BadResponseException;
// use App\Traits\Session;

trait ZohoTrait
{
    protected function getEnv2()
    {
        return [
            'authToken'         => config('values.zohoToken'),
            'baseUrl'           => 'https://mail.zoho.com/api/organization/'.config('values.zohoOrgId'),
            'getZohoBaseUrl'    => 'http://mail.zoho.com/api/organization/',
            'ZohoOrgId'         => config('values.zohoOrgId'),
        ];
    }

    protected function countUsersInOrg()
    {
        $env = $this->getEnv2();
        $url = $env['getZohoBaseUrl'].$env['ZohoOrgId'];
        $client = new Client(
            [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Zoho-authtoken '.$env['authToken'],
                ],
            ]
        );

        try {
            $response = $client->request('GET', $url);
            $data = json_decode($response->getBody());
        } catch (RequestException $e) {
            return $e->getMessage();
        }

        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody());
            $data = $data->data->usersCount; //USers count in org
        } else {
            $data = json_decode($response->getBody());
        }

        return response()->json($data, 200);
    }

    protected function getZohoAccount()
    {
        $limit = $this->countUsersInOrg();
        $env = $this->getEnv2();
        $url = $env['getZohoBaseUrl'].$env['ZohoOrgId'].'/accounts';
        $client = new Client(
            [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Zoho-authtoken '.$env['authToken'],
                ],
            ]
        );

        try {
            $response = $client->request('GET', $url, [
                'query' => [
                    'limit' => $limit->original,
                ],
            ]);
        } catch (RequestException $e) {
            return $e->getMessage();
        }

        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody()->getContents());
        } else {
            $data = json_decode($response->getBody()->getContents());
        }

        return response()->json($data, 200);
    }

    /**
     * Create Zoho account.
     *
     * @param $params
     *
     * @return \Illuminate\Http\JsonResponse|string
     */
    protected function createZohoAccount($params)
    {
        /*
         * "zuid": 663084666,
         * "accountId": "6301374000000008002",
         * we need to save those values so we can use that later to remove accounts.
         * */
        $env = $this->getEnv2();

        $defaultParams = [
            'role'                  => 'member',
            'emailAddress'          => '',
            'primaryEmailAddress'   => '',
            'timeZone'              => 'Asia/Karachi',
            'language'              => 'En',
            'displayName'           => '',
            'password'              => '',
            'userExist'             => false,
            'country'               => 'pk',
        ];
        $defaultParams = array_merge($defaultParams, $params);
        $client = new Client(
            [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Zoho-authtoken '.$env['authToken'],
                ],
            ]);

        try {
            $response = $client->request('POST', $env['baseUrl'].'/accounts', [
                'json' => $defaultParams,
            ]);
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                $msg = json_decode($e->getResponse()->getBody()->getContents())->data->moreInfo;
            }
        } catch (ServerException $e) {
            $msg = 'Server Error';
        }

        if (isset($response) && $response->getStatusCode() == 200) {
            $data = json_decode($response->getBody()->getContents());
        } else {
            $data = '';
            session()->flash('error', $msg);
            // dd( $response);
        }

        return response()->json($data, 200);
    }

    protected function updateZohoAccount($params, $acc_id)
    {
        /*
         * "zuid": 663084666,
         * "accountId": "6301374000000008002",
         * we need to save those values so we can use that later to remove accounts.
         **/
        $env = $this->getEnv2();
        $defaultParams = [
            'mode'                  => 'disableUser', /*enableUser*/
            'zuid'                  => '', //
            'password'              => '',
            //"resetAuthtoken"        => true
        ];
        $defaultParams = array_merge($defaultParams, $params);
        $client = new Client([
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Zoho-authtoken '.$env['authToken'],
            ],
        ]);

        try {
            $response = $client->request('PUT', $env['baseUrl'].'/accounts'.'/'.$acc_id, [
                'json' => $defaultParams,
            ]);
        } catch (RequestException $e) {
            $msg = $e->getMessage();
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                $msg = 'Invalid Input';
            }
        } catch (ServerException $e) {
            $msg = 'Server Error';
        }

        if (isset($response) && $response->getStatusCode() == 200) {
            $data = json_decode($response->getBody());
        } else {
            $data = '';
            session()->flash('error', $msg);
        }

        return response()->json($data, 200);
    }

    protected function deleteZohoAccount($params)
    {
        /*
         * "zuid": 663084666,
         * "accountId": "6301374000000008002",
         * we need to save those values so we can use that later to remove accounts.
         **/
        $env = $this->getEnv2();

        $defaultParams = [
            'zuid'      => '',
            'password'  => '',
        ];
        $defaultParams = array_merge($defaultParams, $params);

        $client = new Client([
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Zoho-authtoken '.$env['authToken'],
            ],
        ]);

        try {
            $response = $client->request('DELETE', $env['baseUrl'].'/accounts', [
                //query past
                'json' => $defaultParams,
            ]);
        } catch (\Exception $e) {
            return 'Success';
        }

        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody());
        } else {
            $data = json_decode($response->getBody());
        }

        return response()->json($data, 200);
    }
}
