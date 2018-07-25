<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\BaseApiController;
use App\Http\Controllers\ResponseMessage;
use Illuminate\Http\Request;

class LoginController extends BaseApiController
{
    use IssueTokenTrait;

    /**
     * @SWG\Post(
     *   path="/api/auth/login",
     *   summary="Returns an access token and refresh token",
     *   tags = {"auth"},
     *   operationId="login",
     *    @SWG\Parameter(
     *   	name="params",
     *   	description="Parameters to pass (in body)",
     *   	@SWG\Schema(
     *   		type="object",
     *   		@SWG\Property(
     *   			property="email",
     *   			type="string"
     *   		),
     *   		@SWG\Property(
     *   			property="password",
     *   			type="string"
     *   		),
     *   	),
     *   	required=true,
     *   	in="body"
     *   ),
     *   @SWG\Response(response=200, description="successful operation")
     * )
     *
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required',
            'password' => 'required',
        ]);

        return $this->issueToken($request, 'password');
    }

    /**
     * @SWG\Post(
     *   path="/api/auth/refresh",
     *   summary="Refresh access token for a user",
     *   tags = {"auth"},
     *   operationId="refresh",
     *   @SWG\Parameter(
     *   	name="params",
     *   	description="Parameters to pass (in body)",
     *   	@SWG\Schema(
     *   		type="object",
     *   		@SWG\Property(
     *   			property="refresh_token",
     *   			type="string",
     *   			default=""
     *   		)
     *   	),
     *   	required=true,
     *   	in="body"
     *   ),
     *   @SWG\Response(response=200, description="successful operation")
     * )
     *
     */
    public function refresh(Request $request)
    {
        $this->validate($request, [
            'refresh_token'    => 'required',
        ]);

        return $this->issueToken($request, 'refresh_token');
    }

    /**
     * @SWG\Post(
     *   path="/api/auth/logout",
     *   summary="Destroys access token and refresh token",
     *   tags = {"auth"},
     *   operationId="logout",
     *    @SWG\Parameter(
     *   	name="Authorization",
     *   	description="Use the keyword 'Bearer' before the access-key. Example 'Bearer 0123456789_access-key-goes-here_987654321",
     *   	type="string",
     *   	required=true,
     *   	in="header"
     *   ),
     *   @SWG\Response(response=200, description="successful operation")
     * )
     *
     */
    public function logout(Request $request)
    {
        $this->revokeTokens($request);

        return ResponseMessage::Report ("logged out", "success");
    }

}
