<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\Contact;

class ContactController extends Controller
{
    public function contactUs(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'country'=>'required',
            'title'=>'required',
            'message'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 200,
                'message' => implode("\n",$validator-> messages()-> all()) ]);
        }
        $item = new Contact();
        $item->name = $request->get('name');
        $item->email = $request->get('email');
        $item->phone = $request->get('phone');
        $item->country=$request->get('country');
        $item->title=$request->get('title');
        $item->message = $request->get('message');
        $item->save();
        $message = ('done_successfully');
        return response()->json(['status' => true,  'message' => $message,   ]);

        
    }

}
