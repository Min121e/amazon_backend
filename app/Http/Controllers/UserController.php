<?php

namespace App\Http\Controllers;

// use App\Models\Favorite;
use App\Models\Favourite;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    public function registration(Request $request) {
        $credentials = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        
        // Check if the email is already taken
        $existinguser = User::where('email', $credentials['email'])->first();
        if($existinguser) {
            return response()->json(['error'=>'Email already in use'], 400);
        }
        
        $user = new User;
        $user->name = $credentials['name'];
        $user->email = $credentials['email'];
        $user->password = bcrypt($credentials['password']);
        $user->save();
        return response()->json(['message'=>'User created successfully']);
    }


    public function signin(Request $request) {
        $credentials = $request->validate([
            'email' => 'required | email',
            'password' => 'required'
        ]);
    
        if (Auth::attempt($credentials)) {
            $user = User::where('email', $credentials['email'])->first();
            // $user = auth()->user;
            // $user = Auth::user()->id;
            if ($user && Hash::check($credentials['password'], $user->password)) {
                $token = $request->user()->createToken('api_token')->plainTextToken;
                return response()->json(['user' => $user, 'token' => $token]);
            }
        }
        return response()->json(['error' => 'Email or password is incorrect'], 401);
    }
    

    // public function signout(Request $request) {
        // $request->auth()->user()->id->tokens()->delete();
        // return auth()->user;
        // $request->user()->currentAccessToken()->delete();

        // $request->user()->tokens()->delete();
        // return response()->json(['message' => 'Logged Out'], 200);
        
        // return Auth::logout();


        // 2.
        // Get bearer token from the request
        // $accessToken = $request->bearerToken();
        
        // // Get access token from database
        // $token = PersonalAccessToken::findToken($accessToken);

        // // Revoke token
        // $token->delete();
    // }

    public function signout(Request $request) {
        try {
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Logged Out'], 200);
        } catch (\Exception $e) {
            Log::error('Error during logout: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred during logout'], 500);
        }
    }

    // public function signin(Request $request) {
    //     $credentials = $request->validate([
    //         'email' => 'required',
    //         'password' => 'required'
    //     ]);
    
    //     // Attempt to authenticate the user
    //     if (Auth::attempt($credentials)) {
    //         // If authentication is successful, you can retrieve the authenticated user using the Auth facade
    //         $user = Auth::user();
    //         $token = $user->createToken('api-token')->plainTextToken;
    
    //         return response()->json(['user' => $user, 'token' => $token]);
    //     }
    
    //     return response()->json(['error' => 'Email or password is incorrect'], 401);
    // }
    
    
    



   



    public function loggedinuser() {
        return Auth::user();
    }
    


    

    


    public function userinfo($id) {
        if (auth()->check()) {
            $user = User::find($id);
    
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
    
            return response()->json(['user' => $user]);
        } else {
            return response()->json(['error' => 'User not haha authenticated'], 401); // Use 401 for unauthenticated access.
        }
        return response()->json(['error' => 'User not haha authenticated'], 401);
    }
    

    // public function userinfo($id) {
    //     if(Auth::id()) {
    //         $user = User::find($id);
    //         // $user = User::all();
    //         return $user;
    //     } else {
    //         return response()->json(['error' => 'User is not authenticated'], 401);
    //     }
    // }


    // public function signin(Request $request) {
    //     $credentials = $request->validate([
    //         'email' => 'required',
    //         'password' => 'required'
    //     ]);
    
    //     if (Auth::attempt($credentials)) {
    //         $user = User::where('email', $credentials['email'])->first();
    //         if ($user && Hash::check($credentials['password'], $user->password)) {
    //             $token = $user->createToken('api-token')->plainTextToken;
    //             $cookie = cookie('api_token', $token, 60*24); //name, token variable, validity duration
    //             return response(['user' => $user])->withCookie($cookie);
    //         }
    //     }
    //     return response()->json(['error' => 'Email or password is incorrect'], 401);
    // }



    // public function addToFavourite(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'product_id' => 'required|exists:products,id',
    //     ]);

    //     // Check if the user already has this product in favorites
    //     if (!$request->user()->favourites()->where('product_id', $request->product_id)->exists()) {
    //         // If not, attach the product to the user's favorites
    //         $request->user()->favourites()->attach($request->product_id);
            
    //         // You can return a success response here if needed
    //         return response()->json(['message' => 'Product added to favourites successfully']);
    //     }

    //     // You can return a response here indicating that the product is already in favorites
    //     return response()->json(['message' => 'Product already in favourites']);
    // }


    public function addToFavourite(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        // Ensure the user is authenticated
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Check if the user already has this product in favorites
        if (!$request->user()->favourites()->where('product_id', $request->product_id)->exists()) {
            // If not, attach the product to the user's favorites
            $request->user()->favourites()->attach($request->product_id);

            // You can return a success response here if needed
            return response()->json(['message' => 'Product added to favourites successfully']);
        }

        // You can return a response here indicating that the product is already in favourites
        return response()->json(['message' => 'Product already in favourites']);
    }
    

}
