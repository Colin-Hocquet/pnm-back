<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    /**
     * Création d'un nouvel utilisateur
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
            User::create([
                'name' => $validatedData['name'],
                'firstname' => $validatedData['firstname'],
                'lastname' => $validatedData['lastname'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);
            return response()->json([
                'message' => __('User created'),
                'result'  => true
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage(),
                'result'  => false
            ]);
        }
        // if(User::create([
        //             'name' => $validatedData['name'],
        //             'firstname' => $validatedData['firstname'],
        //             'lastname' => $validatedData['lastname'],
        //             'email' => $validatedData['email'],
        //             'password' => Hash::make($validatedData['password']),
        //     ])){
        //         return response()->json([
        //             'success' => 'Utilisateur créé avec succés !'
        //         ],200);
        //     } else {

        //     }

        // $token = $user->createToken('auth_token')->plainTextToken;

        // return response()->json([
        //             'access_token' => $token,
        //                 'token_type' => 'Bearer',
        // ]);
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
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
     
        $token = $user->createToken($request->device_name)->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
    ]);
    }

}
