<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    

    public function showproduct() {
        return Product::all();
    }

    // public function addtocart(Request $request, $id) {
    //     if(Auth::id()) {
    //         $user_id = Auth::id();
    //         // $product_id = Product::find($id);

    //         // $cart = new Cart();
    //         // $cart->user_id = $user_id;
    //         // $cart->product_id = $product_id;
    //         // $cart->save();

    //         // return back();
    //         return $user_id;
    //     }
        
    // }


    // public function updateCart(Request $request) {
    //     return 'helllo';
    // }


    // 3
    public function updateCart(Request $request) {
        $user_id = Auth::user()->id;
        if ($user_id) {
            $products = $request->input('cartItems');

            foreach ($products as $product) {
                $existingCartItem = Cart::where('user_id', $user_id)
                    ->where('product_id', $product['id'])
                    ->first();

                if ($existingCartItem) {
                    $existingCartItem->quantity += $product['quantity'];
                    $existingCartItem->save();
                } else {
                    $cart = new Cart();
                    $cart->user_id = $user_id;
                    $cart->product_id = $product['id'];
                    $cart->quantity = $product['quantity'];
                    $cart->save();
                }
            }

            return response()->json(['message' => 'Cart updated successfully'], 201);
        }
         else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }




    // 2
    // public function updateCart(Request $request) {
    //     $user_id = Auth::user()->id;
    //     if ($user_id) {
    
    //         $existingCartItem = Cart::where('user_id', $user_id)
    //             ->where('product_id', $request->id)
    //             ->first();
    
    //         if ($existingCartItem) {
    //             $existingCartItem->quantity += $request->quantity;
    //             $existingCartItem->save();
    //         } else {
    //             $cart = new Cart();
    //             $cart->user_id = $user_id;
    //             $cart->product_id = $request->id;
    //             $cart->quantity = $request->quantity;
    //             $cart->save();
    //         }
    
    //         return response()->json(['message' => 'Cart updated successfully']);
    //     } else {
    //         return response()->json(['message' => 'User not authenticated'], 401);
    //     }
    // }

  

    // 1
    // public function updateCart(Request $request) {
    //     if (Auth::user()->id) {
    //         $user_id = Auth::user()->id;
    
    //         // Loop through the cartItems array and update cart items
    //         foreach ($request->cartItems as $cartItem) {
    //             $existingCartItem = Cart::where('user_id', $user_id)
    //                 ->where('product_id', $cartItem['id'])
    //                 ->first();
    
    //             if ($existingCartItem) {
    //                 $existingCartItem->quantity += $cartItem['quantity'];
    //                 $existingCartItem->save();
    //             } else {
    //                 $cart = new Cart();
    //                 $cart->user_id = $user_id;
    //                 $cart->product_id = $cartItem['id'];
    //                 $cart->quantity = $cartItem['quantity'];
    //                 $cart->save();
    //             }
    //         }
    
    //         return response()->json(['message' => 'Cart updated successfully']);
    //     } else {
    //         return response()->json(['message' => 'User not authenticated'], 401);
    //     }
    // }
    



    public function addtocart(Request $request, $id) {
        if (Auth::id()) {
            $user_id = Auth::id();
            // Perform actions that require authentication, e.g., adding to the cart
            return $user_id;
        } else {
            // User is not authenticated
            return response()->json(['error' => 'User is not authenticated'], 401);
        }
    }
    
}
