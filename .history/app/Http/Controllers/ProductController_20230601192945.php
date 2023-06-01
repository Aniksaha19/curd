<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        return view('products.index', [
            'products'=>Product::get()
        ]);
    }
    public function create(){
        return view('products.create');
    }
    public function store(Request $request){

        //validate date
        $request->validate([
            'name' => 'required',
            'description'=> 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1000'
        ]);
        //upload image
        // dd($request->all());
        $imagesName = time().'.'.$request->image->extension();
        $request->image->move(public_path('products'), $imagesName);

        $product = new Product;
        $product->image = $imagesName;
        $product->name = $request->name;
        $product->description = $request->description;

        $product->save();
        return back()->withSuccess('Product Created !!!!!');
        // dd($imagesName);
    }
    public function edit($id){
        $product = product::where('id', $id)->first();
        return view('products.edit',['product' => $product]);
    }

    public function update(Request $request, $id){
        // dd($request->all());
         //validate date
         $request->validate([
            'name' => 'required',
            'description'=> 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:1000'
        ]);
        $product = Product::where('id', $id)->first();

        if(isset($request->image)){
             //upload image
        // dd($request->all());
        $imagesName = time().'.'.$request->image->extension();
        $request->image->move(public_path('products'), $imagesName);
        $product->image = $imagesName;
        }
        $product->name = $request->name;
        $product->description = $request->description;

        $product->save();
        return back()->withSuccess('Product Updated !!!!!');
    }
    p
}
