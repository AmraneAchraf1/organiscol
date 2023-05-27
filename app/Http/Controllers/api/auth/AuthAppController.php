<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthAppController extends Controller
{


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        # validate the data
        $data = $request->validate([
            "username" => "required|string|unique:users",
            "password" => "required|string",
        ]);
        # hash the password
        $data["password"] = Hash::make($data["password"]);
        # create the user
        $user = User::create($data);

        # check if the user is created
        if ($user) {
            return response()->json(["success" => true, "user" => $user]);
        } else {
            return response()->json(["success" => false], 400);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        # validate the data
        $data = $request->validate([
            "username" => "required|string",
            "password" => "required|string",
        ]);
        # check if the user exists
        $user = User::where("username", $data["username"])->first();
        if ($user) {
            # check if the password is correct
            if (Hash::check($data["password"], $user->password)) {
                # generate a token with user abilities
                $token = $user->createToken($request->userAgent(), ["user"] )->plainTextToken;
                # return the token
                return response()->json(["success" => true, "token" => $token]);
            } else {
                return response()->json(["success" => false, "message" => "wrong password"], 400);
            }
        } else {
            return response()->json(["success" => false, "message" => "user not found"], 400);
        }
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        # get the user
        $user = $request->user();
        # delete the token
        $user->currentAccessToken()->delete();
        # return the response
        return response()->json(["success" => true, "message" => "user logged out"]);
    }
}
