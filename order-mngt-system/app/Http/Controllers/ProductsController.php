<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function productView(){
        $productData = Product::where('addby_id',Auth::user()->id)->paginate(10);
        return view('Products.productView',compact('productData'));
    }

    public function addProduct(Request $request){
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->addby_id =Auth::user()->id;
        $product->save();
        return redirect()->route('productView');
    }

    public function deleteProduct(Request $request){
        Product::where('id',$request->input('id'))->delete();
        return redirect()->route('productView');
    }

    public function getProduct(Request $request){
        $product = Product::select('name','description','price','stock','id')
                    ->where('id',$request->input('id'))
                    ->first();
        return response()->json($product);
    }

    public function updateProduct(Request $request){
        $product = Product::find($request->input('product_id'));
        $product->name = $request->input('product_name');
        $product->description = $request->input('product_description');
        $product->price = $request->input('product_price');
        $product->stock = $request->input('product_stock');
        $product->save();
        return redirect()->route('productView');
    }
}
