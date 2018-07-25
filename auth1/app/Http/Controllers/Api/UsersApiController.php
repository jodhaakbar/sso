<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use App\Http\Controllers\ResponseMessage;
use App\User;
use Illuminate\Http\Request;
use Exception;

class UsersApiController extends BaseApiController {

    /**
     * @SWG\Get(
     *   path="/api/users/",
     *   summary="List all users",
     *   tags = {"users"},
     *   operationId="index",
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
    public function index(Request $request) {
        try {
            $users = User::all();

            return ResponseMessage::Report("users_listt", "success", $users);
        } catch (Exception $e) {
            return ResponseMessage::Report($e->getMessage(), "error");
        }

    }

    /**
     * @SWG\Post(
     *   path="/api/users",
     *   summary="Create a new user",
     *   tags = {"users"},
     *   operationId="create",
     *   @SWG\Parameter(
     *   	name="Authorization",
     *   	description="Use the keyword 'Bearer' before the access-key. Example 'Bearer 0123456789_access-key-goes-here_987654321",
     *   	type="string",
     *   	required=true,
     *   	in="header"
     *   ),
     *   @SWG\Parameter(
     *   	name="params",
     *   	description="Parameters to pass (in body)",
     *   	@SWG\Schema(
     *   		type="object",
     *   		@SWG\Property(
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
     *   		),
     *   	),
     *   	required=true,
     *   	in="body"
     *   ),
     *   @SWG\Response(response=200, description="successful operation")
     * )
     *
     */
    public function create(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            return ResponseMessage::Report("user_created", "success", $user);

        } catch (Exception $e) {
            return ResponseMessage::Report($e->getMessage(), "error");
        }
    }

    /**
     * @SWG\Get(
     *   path="/api/users/{id}",
     *   summary="Get a user by its ID",
     *   tags = {"users"},
     *   operationId="show",
     *    @SWG\Parameter(
     *   	name="Authorization",
     *   	description="Use the keyword 'Bearer' before the access-key. Example 'Bearer 0123456789_access-key-goes-here_987654321",
     *   	type="string",
     *   	required=true,
     *   	in="header"
     *   ),
     *   @SWG\Parameter(
     *   	name="id",
     *   	description="User's ID",
     *   	type="integer",
     *   	required=true,
     *   	in="path"
     *   ),
     *   @SWG\Response(response=200, description="successful operation")
     * )
     *
     */
    public function show(Request $request, $id) {
        try {
            $user = User::find($id);

            if (empty($user)) {
                return ResponseMessage::Report("user_not_found", "error");
            }

            return ResponseMessage::Report("user_by_id", "success", $user);

        } catch (Exception $e) {
            return ResponseMessage::Report($e->getMessage(), "error");
        }
    }

    /**
     * @SWG\Put(
     *   path="/api/users/{id}",
     *   summary="Updates a given user",
     *   tags = {"users"},
     *   operationId="update",
     *   @SWG\Parameter(
     *   	name="Authorization",
     *   	description="Use the keyword 'Bearer' before the access-key. Example 'Bearer 0123456789_access-key-goes-here_987654321",
     *   	type="string",
     *   	required=true,
     *   	in="header"
     *   ),
     *   @SWG\Parameter(
     *   	name="id",
     *   	description="User's ID",
     *   	type="integer",
     *   	required=true,
     *   	in="path"
     *   ),
     *   @SWG\Parameter(
     *   	name="params",
     *   	description="Parameters to pass (in body)",
     *   	@SWG\Schema(
     *   		type="object",
     *   		@SWG\Property(
     *   			property="name",
     *   			type="string",
     *   			default=""
     *   		),
     *          @SWG\Property(
     *   			property="email",
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
    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'email'    => 'required|email|unique:users,email,'.$id
        ]);

        try {
            $user = User::find($id);

            if (empty($user)) {
                return ResponseMessage::Report("user_not_found", "error");
            }

            $user->fill($request->all());
            $user->save();

            return ResponseMessage::Report("user_updated", "success", $user);
        } catch (Exception $e) {
            return ResponseMessage::Report($e->getMessage(), "error");
        }
    }

    /**
     * @SWG\Delete(
     *   path="/api/users/{id}",
     *   summary="Get a user by its ID",
     *   tags = {"users"},
     *   operationId="show",
     *    @SWG\Parameter(
     *   	name="Authorization",
     *   	description="Use the keyword 'Bearer' before the access-key. Example 'Bearer 0123456789_access-key-goes-here_987654321",
     *   	type="string",
     *   	required=true,
     *   	in="header"
     *   ),
     *   @SWG\Parameter(
     *   	name="id",
     *   	description="User's ID",
     *   	type="integer",
     *   	required=true,
     *   	in="path"
     *   ),
     *   @SWG\Response(response=200, description="successful operation")
     * )
     *
     */
    public function delete(Request $request, $id) {
        try {
            $user = User::find($id);

            if (empty($user)) {
                return ResponseMessage::Report("user_not_found", "error");
            }
            $user->delete();

            return ResponseMessage::Report("user_deleted", "success");

        } catch (Exception $e) {
            return ResponseMessage::Report($e->getMessage(), "error");
        }
    }

}