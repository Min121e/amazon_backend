<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function addproduct(Request $request) {
        $usertype = Auth::user()->usertype;
        // if(Auth::id()) {
        if($usertype == '1') {
         $product = new Product();
         $product->title = $request->input('title');
         $product->description = $request->input('description');
         $product->price = $request->input('price');
         $product->category = $request->input('category');
        //  $product->image = $request->file('image')->store('/public/products');
         $path = $request->file('image')->store('public/images');
         $pathWithoutPublic = str_replace('public/', '', $path);
         $product->image = $pathWithoutPublic;
         $product->save();
         return $product;   
        } else {
            return response()->json(['error' => 'This action is not authorized.'], 401);
        }         
    } 
}
