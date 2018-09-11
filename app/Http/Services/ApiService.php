<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;

class ApiService
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->http = new Client;
    }

    /**
     * Create a new corporate user
     *
     * @param string $email
     * @param string $password
     * @param string $company
     * @param string $expires
     * @param bool $marketing
     * @return mixed
     * @throws \Exception
     */
    public function createUser($email, $password, $company, $expires, $marketing)
    {
        $duration = Carbon::now()->diffInDays(Carbon::createFromTimestampUTC($expires));
        $request = [
            'users'            => [
                ['username' => $email, 'password' => $password]
            ],
            'group'            => $company,
            'group_duration'   => $duration,
            'trial_duration'   => $duration,
            'anonymous'        => false,
            'corporate'        => true,
            'terms'            => true,
            'gdpr'             => true,
            'marketing_opt_in' => $marketing,
        ];

        $response = $this->http->post($this->endpoint('freeuser'), [
            'json' => $this->sign($request),
        ]);

        $response = json_decode($response->getBody()->getContents());

        if ($response->success && count($response->data->errors) || ! $response->success) {
            $error = array_first($response->data->errors);
            throw new \Exception($error->message, $error->code);
        } elseif ( ! $response->success) {
            throw new \Exception($response->message, $response->code);
        }

        return $response;
    }
    
    public function removeUser($email, $company)
    {
        $request = [
            'email' => $email,
            'company' => $company
        ];

        $response = $this->http->post($this->endpoint('freeuser/unsubscribe'), [
            'json' => $this->sign($request),
        ]);

        $response = json_decode($response->getBody()->getContents());

        return $response;
    }

    /**
     * Count existing users
     *
     * @param string $company
     * @return mixed
     * @throws \Exception
     */
    public function countUsers($company)
    {
        $response = $this->http->post($this->endpoint('freeuser/count'), [
            'json' => [
                'group' => $company
            ],
        ]);

        $response = json_decode($response->getBody()->getContents());

        if ( ! $response->success ) {
            throw new \Exception($response->message, $response->code);
        }

        return isset($response->data) ? $response->data : 0;
    }

    /**
     * Add signature to request
     *
     * @param array $request
     * @return array
     */
    private function sign($request)
    {
        $secret = config('mps.secret');
        $today = Carbon::now()->format('Ymd');
        $nonce = str_random(rand(16,50));
        $toSign = $secret . $today . $nonce;

        return array_collapse([
            $request,
            [
                'signature' => hash_hmac('sha256', $toSign, $secret),
                'nonce'     => $nonce,
            ]
        ]);
    }

    /**
     * Url builder
     *
     * @param string $uri
     * @return string
     */
    private function endpoint($uri)
    {
        return str_finish(config('mps.api_base'), '/') .
            str_finish(config('mps.api_version'), '/') . $uri;
    }
}
