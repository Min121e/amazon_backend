<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle(Request $request, Closure $next)
    // {

    //     return $next($request);
    // }

    public function handle($request, Closure $next)
    {
        // $authorizationHeader = $request->header('Authorization');

        // if (strpos($authorizationHeader, 'Bearer ') === 0) {
        //     // Remove the "Bearer " prefix to get the token
        //     $accessToken = substr($authorizationHeader, 7);


        //     $token = explode('|', $accessToken)[1];
        //     $token = Hash::make($token);


        //     var_dump($token);
        //     die();

        //     if ($accessToken) {
        //         $tokenRecord = PersonalAccessToken::where('token', $token)->first();

        //         if ($tokenRecord) {
        //             Auth::loginUsingId($tokenRecord->tokenable_id);
        //             return $next($request);
        //         }
        //     }
        // }


        // return response()->json(['message' => 'Unauthorized'], 401);
    }
}
