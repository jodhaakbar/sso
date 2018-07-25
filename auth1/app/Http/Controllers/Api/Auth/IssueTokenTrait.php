<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

trait IssueTokenTrait
{
    private $client;

    public function __construct()
    {
        $this->client = Client::find(1);
    }

    public function issueToken(Request $request, $grantType, $scope = "*")
    {
        $params = [
            'grant_type'    => $grantType,
            'client_id'     => $this->client->id,
            'client_secret' => $this->client->secret,
            'username'      => $request->email,
            'scope'         => $scope,
        ];

        // Re dispatch the request with $params
        // Generate token
        $request->request->add($params);

        $proxy = Request::create('oauth/token', 'POST');

        return Route::dispatch($proxy);
    }

    public function revokeTokens(Request $request)
    {
        $accessToken = Auth::user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);

        $accessToken->revoke();
    }

}