<?php

namespace App\Traits;

use GuzzleHttp\Client as Client;

trait SlackTrait
{
    protected function createSlackInvitation($email, $token)
    {

        //token and the email of the employee is get
        $url = 'https://slack.com/api/users.admin.invite';
        $client = new Client();

        try {
            $response = $client->request('POST', $url, [

                'form_params'=> [
                    'token'  => $token,
                    'email'  => $email,
                    'resend' => true, // resend true means invitation is send multiple time if need
                ], ]);
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
}
