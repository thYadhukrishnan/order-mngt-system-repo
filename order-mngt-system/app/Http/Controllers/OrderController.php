<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderDetails;
use App\Models\Customer;
use App\Models\OrderDetails;
use App\Models\OrderedProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function orderDetails(){
        $customers = Customer::where('addby_id',Auth::user()->id)->get();
        $products  = Product::where('addby_id',Auth::user()->id)->where('stock','>',0)->get();
        $orderDetails = OrderDetails::where('addby_id',Auth::user()->id)->with('customer')->paginate(10);
        return view('Order.order',compact('customers','products','orderDetails'));
    }

    public function addOrder(Request $request){
        // return $request->all();
        $productlist = $request->input('product');
        $countList = $request->input('count');
        $orderDetails = new OrderDetails();
        $orderDetails->customer_id = $request->input('customerName');
        $orderDetails->addby_id = Auth::user()->id;
        $orderDetails->save();
        $totalAmount = 0;
        if(!empty($productlist)){
            for($i = 0; $i< count($productlist); $i++){
                $productId = $productlist[$i];
                $productCount = $countList[$i];

                $product = Product::find($productId);

                
                if($product->stock >= $productCount){
        
                    $orderedProduct = new OrderedProduct();
                    $orderedProduct->order_id = $orderDetails->id;
                    $orderedProduct->product_id = $product->id;
                    $orderedProduct->quantity = $productCount;
                    $orderedProduct->subtotal = $productCount * $product->price;
                    $orderedProduct->addby_id = Auth::user()->id;
                    $orderedProduct->save();

                    $product->stock -= $productCount;
                    $product->save();
                    $totalAmount +=  $productCount * $product->price;
                }

            }
        }
        $orderDetails->total_amount = $totalAmount;
        if($totalAmount > 0){
            $orderDetails->status = "Completed";
            SendOrderDetails::dispatch($orderDetails);
        }
        $orderDetails->save();

        return redirect()->route('orderDetails');
    }
}
