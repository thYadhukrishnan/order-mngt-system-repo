<?php

namespace App\Http\Controllers;

use App\Models\OrderDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function apiLogin(Request $request){
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);


        $user = User::where('email',$validated['email'])->first();
        if($user && Hash::check($validated['password'],$user->password)){
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'token'=> $token,
                // 'user' => $user,
                'message'=> 'Loged in',
                'status' => true,
            ],200);
        }else{
            return response()->json([
                'message' => 'Invalid Cred',
                'status'=> false,
            ],401);
        }
    }

    public function apiLogout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out',
        ]);
    }

    public function getOrderDetails(Request $request){
        $orderDetails = OrderDetails::where('addby_id',$request->user()->id)->with('customer')->paginate(10);
        return response()->json($orderDetails);
    }
}
