<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

	/**
	 * Create user
	 *
	 * @param  [string] name
	 * @param  [string] email
	 * @param  [string] password
	 * @param  [string] password_confirmation
	 * @return [string] message
	 */
	public function register(Request $request)
	{
		$request->validate([
			'name' => 'required|string',
			'email' => 'required|string|unique:users',
			'password' => 'required|string',
			'confirm_password' => 'required|same:password'
		]);

		$user = new User([
			'name'  => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
		]);

		if ($user->save()) {
			return response()->json([
				'msg' => 'Successfully registered. You can login now!',
			], 201);
		} else {
			return response()->json(['error' => 'Provide proper details']);
		}
	}

	/**
	 * Login user and create token
	 *
	 * @param  [string] email
	 * @param  [string] password
	 * @param  [boolean] remember_me
	 */

	public function login(Request $request)
	{
		$request->validate([
			'email' => 'required|string|email',
			'password' => 'required|string',
			'remember_me' => 'boolean'
		]);

		$credentials = request(['email', 'password']);
		if (!Auth::attempt($credentials)) {
			return response()->json([
				'msg' => 'Wrong credentials'
			], 401);
		}

		$user = $request->user();
		$tokenResult = $user->createToken('Personal Access Token');
		$token = $tokenResult->plainTextToken;

		$user = User::select('users.id', 'users.name', 'users.email', 'users.role_id','roles.slug as role')
								->join('roles', 'roles.id', '=', 'users.role_id')
								->first();

		if($user->role == 'admin') {
			$abilities = array (
					array(
						'action' => 'manage',
						'subject' => 'all',
					)
			);
		}
		else {
			$abilities = array (
					array(
						'action' => 'read',
						'subject' => 'Auth',
					),
			);
		}


		return response()->json([
			'userData' => $user,
			'userAbilities' => $abilities,
			'accessToken' => $token,
			'token_type' => 'Bearer',
		]);
	}

	/**
	 * Logout user (Revoke the token)
	 *
	 * @return [string] message
	 */
	public function logout(Request $request)
	{
		$request->user()->tokens()->delete();

		return response()->json([
			'msg' => 'Successfully logged out'
		]);
	}

}
