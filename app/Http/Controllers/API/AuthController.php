<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
    	// Validate registration data
    	$validatedData = $request->validate([
    		'name' => 'required|max:55',
    		'email' => 'required|email|unique:users',
    		'password' => 'required|confirmed',
    	]);

    	// Request returns a response automatically if validation fails
    	// Can still decide to handle the validation failure response
    	// Encrypt the user's password
    	$validatedData['password'] = bcrypt($request->password);

    	// Create and store user in database
        DB::beginTransaction();
        try {
            $user = User::create($validatedData);
            // Get the token needed to grant the user access
            $accessToken = $user->createToken('authToken')->accessToken;
        } catch (\Throwable $e) {
            DB::rollback();
            return response(['message' => 'An error occured'], 500);
        }

        DB::commit();

    	return response([ 'user' => $user, 'access_token' => $accessToken ]);
    }

    public function login(Request $request)
    {
    	// Validate login data
    	$loginData = $request->validate([
    		'email' => 'required|email|',
    		'password' => 'required|'
    	]);

    	// Check if the login data is valid
    	if (!auth()->attempt($loginData)) {
    		return response(['message' => 'Invalid Credentials']);
    	}

    	// Get the token needed to grant the user access
    	$accessToken = auth()->user()->createToken('authToken')->accessToken;

    	return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

    public function logout()
    {
        $token = auth()->user()->token();
        $token->revoke();
        return response(['message' => 'Unauthenticated'], 401);
    }

}
