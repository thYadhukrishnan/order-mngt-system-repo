<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class CustomerController extends Controller
{
    public function addCustView(){
        
        $customerData = Customer::where('addby_id',operator: Auth::user()->id)->paginate(10);
        return view('Customer.addCustView',compact('customerData'));
    }

    public function saveCust(Request $request){
        $customer = new Customer();
        $customer->name = $request->input('custname');
        $customer->email = $request->input('custmail');
        $customer->phone = $request->input('custphone');
        $customer->address = $request->input('custaddress');
        $customer->addby_id = Auth::user()->id;
        $customer->save();
        return redirect()->route('addCustView');
    }

    public function checkMail(Request $request){
        $mail = $request->input('mail');
        $from = $request->input('from');
        if($from == 'add'){
            $exists = Customer::where('email', $mail)->exists();
        }else{
            $exists =Customer::where('email', $mail)
                    ->where('id','!=',$request->input('id'))
                    ->exists();
        }
        return response()->json(!$exists);
    }

    public function deleteCust(Request $request){
        Customer::where('id',$request->input('id'))->delete();
        return redirect()->route('addCustView');
    }

    public function getCustData(Request $request){
        $custData = Customer::select('name','email','phone','address','id')
                            ->where('id',$request->input('id'))
                            ->where('addby_id',Auth::user()->id)
                            ->first();
        return response()->json($custData);
    }

    public function updateCust(Request $request){
        $customer = Customer::find($request->input('custid'));
        $customer->name = $request->input('editcustname');
        $customer->email = $request->input('editcustmail');
        $customer->phone = $request->input('editcustphone');
        $customer->address = $request->input('editcustaddress');
        $customer->save();
        return redirect()->route('addCustView');
    }
}
