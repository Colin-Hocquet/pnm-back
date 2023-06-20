<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Création d'un nouvel utilisateur
     * Création de la table Settings pour l'utilisateur
     * @param Request $request
     * @param [string] name
     * @param [string] firstname
     * @param [string] lastname
     * @param [string] email
     * @param [string] password
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:45',
            'firstname' => 'required|string|max:60',
            'lastname' => 'required|string|max:60',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8',
        ]);
        try {
            $user = User::create([
                'name' => $validatedData['name'],
                'firstname' => $validatedData['firstname'],
                'lastname' => $validatedData['lastname'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);
            Settings::create([
                'user_id' => $user->id
            ]);
            return response()->json([
                'message' => __('User created'),
                'result' => true
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'result' => false
            ]);
        }
    }

    /**
     * connexion de l'utilisateur et création du token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] device_name
     * @return [string] access_token
     * @return [string] token_type
     */

    public function login(Request $request)
    {
       return $this->tokenGenerate($request);
    }

    public function loginAdmin(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user != null && $user->is_admin === 1){
            return $this->tokenGenerate($request);
        } else {
            $content = array(
                'success' => false,
                'data' => 'something went wrong.',
                'message' => 'You\'re not admin or credential not know'
            );
            return response($content)->setStatusCode(422);
        }
    }

    /**
     * Lors de la déconnexion, on supprime le token
     * @param Request $request (email / Bearer token)
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $user->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Récupération des infos de l'utilisateur connecté
    * @param Request $request (email / password / Bearer token)
    * @return \Illuminate\Http\JsonResponse
    */
    public function me(Request $request)
    {
        return $request->user();
    }

    /**
     * Génération du token
     * @param Request $request
     * @param [string] email
     * @param [string] password
     * @param [string] device_name
     * @return \Illuminate\Http\JsonResponse
     */
    public function tokenGenerate (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            $content = array(
                'success' => false,
                'data' => 'something went wrong.',
                'message' => 'Credentials not know'
            );
            return response($content)->setStatusCode(422);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expired_at' => now()->addHours(24)->getTimestamp(),
            'user' => $user,
    ]);
    }

}
