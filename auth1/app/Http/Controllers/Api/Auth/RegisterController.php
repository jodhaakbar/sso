<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\BaseApiController;
use App\Http\Controllers\ResponseMessage;
use App\User;
use Illuminate\Http\Request;
use Exception;

class RegisterController extends BaseApiController
{
    use IssueTokenTrait;

    /**
     * @SWG\Post(
     *   path="/api/auth/register",
     *   summary="Create a new user and returns access_token and refresh_token",
     *   tags = {"auth"},
     *   operationId="register",
     *   @SWG\Parameter(
     *   	name="params",
     *   	description="Parameters to pass (in body)",
     *   	@SWG\Schema(
     *   		type="object",
     *          @SWG\Property(
     *   			property="name",
     *   			type="string",
     *   			default=""
     *   		),
     *          @SWG\Property(
     *   			property="email",
     *   			type="string",
     *   			default=""
     *   		),
     *          @SWG\Property(
     *   			property="password",
     *   			type="string",
     *   			default=""
     *   		),
     *          @SWG\Property(
     *   			property="password_confirmation",
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
    public function register(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        try {
            // User::create([
            //     //'name' => $request->name,
            //     //'email' => $request->email,
            //     //'password' => bcrypt($request->password),
            // ]);

            return $this->issueToken($request, 'password');

        } catch (Exception $e) {

            return ResponseMessage::Report($e->getMessage(), "error");

        }
    }
}
