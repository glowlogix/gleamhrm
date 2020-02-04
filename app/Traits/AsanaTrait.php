<?php

namespace App\Traits;

use GuzzleHttp\Client as Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

trait AsanaTrait
{
    protected function getEnv()
    {
        return [
            'asanaToken'       => config('values.asanaToken'),
            'asanaWorkspaceId' => config('values.asanaWorkspaceId'),
        ];
    }

    protected function addUserToOrganization($email)
    {
        $env = $this->getEnv();
        //token and the email of the employee is get
        $url = 'https://app.asana.com/api/1.0/workspaces/'.$env['asanaWorkspaceId'].'/addUser';

        $client = new Client(
            [
                'headers' => [
                    'Authorization' => 'Bearer '.$env['asanaToken'],
                ],
            ]);

        try {
            $response = $client->request('POST', $url, [

                'form_params'=> [
                    'user' => $email,

                ],

            ]);
        } catch (RequestException $e) {
            return $e->getMessage();
        }
        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody()->getContents(), true);
        } else {
            $data = json_decode($response->getBody());
        }

        return response()->json($data, 200);
    }

    protected function addUserToTeam(array $teams, $email)
    {
        $env = $this->getEnv();
        //token and the email of the employee is get
        foreach ($teams as $key =>$val) {
            $url = 'https://app.asana.com/api/1.0/teams/'.$teams[$key].'/addUser';

            $client = new Client(
                [
                    'headers' => [
                        'Authorization' => 'Bearer '.$env['asanaToken'],
                    ],
                ]);

            try {
                $response = $client->request('POST', $url, [
                    'form_params'=> [
                        'user' => $email,
                    ],
                ]);
            } catch (ClientException $e) {
                if ($e->hasResponse()) {
                    $msg = json_decode($e->getResponse()->getBody()->getContents())->data->moreInfo;
                }
            } catch (RequestException $e) {
                return $e->getMessage();
            } catch (ServerException $e) {
                $msg = 'Server Error';
            }
            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody()->getContents(), true);
            } else {
                $data = json_decode($response->getBody());
            }

            return response()->json($data, 200);
        }
    }

    protected function removeUser($email)
    {
        $env = $this->getEnv();
        //token and the email of the employee is get
        $url = 'https://app.asana.com/api/1.0/workspaces/'.$env['asanaWorkspaceId'].'/removeUser';

        $client = new Client(
            [
                'headers' => [
                    'Authorization' => 'Bearer '.$env['asanaToken'],
                ],
            ]);

        try {
            $response = $client->request('POST', $url, [
                'form_params'=> [
                    'user' => $email,
                ],
            ]);
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                // $msg = $e->getResponse();
                $msg = 'Unauthorized user';
            }
        } catch (RequestException $e) {
            return $e->getMessage();
        } catch (ServerException $e) {
            $msg = 'Server Error';
        }

        if (isset($response) && $response->getStatusCode() == 200) {
            $data = json_decode($response->getBody()->getContents());
        } else {
            $data = '';
            // session()->flash('error', $msg);
            // dd( $response);
        }

        return response()->json($data, 200);
    }
}
