<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location_Maared;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Notifications\ResetPassword;

use App\Models\User;
use App\Models\Token;
use Illuminate\Auth\Notifications\ResetPassword as NotificationsResetPassword;
use Laravel\Passport\HasApiTokens;

class UserController extends Controller
{

    public function broker()
    {
        return Password::broker('users');
    }
    public function signUp(Request $request)
    {
    //    return $request;
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email:filter|unique:users',
        'mobile' => 'required|digits:8|unique:users',
        'password' => 'required|min:6',
        'country'=>'required',
        'confirm_password'=>'required',
        'type'=>'required',
        'company'=>'required_if:type,==,4',
        'company_files'=>'required_if:type,==,4|file',
        'files'=>'required_if:type,==,4|file',
        'image'=>'required_if:type,==,4|required_if:type,==,2|file',
        'company_id'=>'required_if:type,==,3|required_if:type,==,2|required_if:type,==,4',
        'package_id'=>'required_if:type,==,3',
        'bio'=>'required_if:type,==,2',
        'service'=>'required_if:type,==,2|array',

        'device_type' => 'required',
    ]);
    if ($validator->fails()) {
        return response()->json(['status' => false, 'code' => 200,
            'message' => implode("\n", $validator->messages()->all())]);
    }
        $newUser = new User();
            $newUser->name = $request->get('name');
            $newUser->mobile = $request->get('mobile');
            $newUser->email = $request->get('email');
            $newUser->password = bcrypt($request->get('password'));
            $newUser->confirm_password= bcrypt($request->get('confirm_password'));
            $newUser->type=$request->get('type');
            $newUser->company=$request->get('company');
            $newUser->company_files=$request->get('company_files');
            $newUser->files=$request->get('files');
            $newUser->image=$request->get('image');
            $newUser->package_id=$request->get('package_id');
            $newUser->bio=$request->get('bio');
            $newUser->service=$request->get('service');
        $newUser->save();
        $accessToken = $newUser->createToken('authToken')->accessToken;
        return response(['user'=> $newUser, 'access_token'=> $accessToken]);
}
    public function login(Request $request){

        $loginData = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = request(['email', 'password']);
        if(!auth()->attempt($credentials)) {
            return response(['message'=>'Invalid credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }
    public function forgotPassword(Request $request)
    {
        return $request;
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 200,
                'message' => implode("\n", $validator->messages()->all())]);
        }
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $message = 'The email not found';
            return response()->json(['status' => false, 'code' => 200, 'message' => $message]);
        }
        $token = $this->broker()->createToken($user);
        $url = url('/password/reset/' . $token);
        $user->notify(new ResetPassword($token));
        $message =('You_will_receive_email');
        return response()->json(['status' => true, 'code' => 200, 'message' => $message]);
    }
    public function changePassword(Request $request)
    {
        $rules = [
            'old_password' => 'required|min:6',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 200,
                'message' => implode("\n", $validator->messages()->all())]);
        }
        $user = auth('api')->user();

        if (!Hash::check($request->get('old_password'), $user->password)) {
            $message = ('wrong_old_password'); //wrong old
            return response()->json(['status' => false, 'code' => 200, 'message' => $message]);
        }

        $user->password = bcrypt($request->get('password'));

       if($user->save()) {
            $user->refresh();
            $message =('ok');
            return response()->json(['status' => true, 'code' => 200, 'message' => $message]);
        }
        $message = ('whoops');
        return response()->json(['status' => false, 'code' => 200, 'message' => $message]);
    }
    public function myProfile()
    {
        $user_id = auth('api')->id();
        $item = User::query()->findOrFail($user_id);
        $message = ('ok');
        return response()->json(['status' => true, 'code' => 200,
            'message' => $message, 'item' => $item->makeHidden(['type','company','files','company_files','image','password','confirm_password','bio','service','email_verified_at','location_maarads','linked_link','inst_link','tw_link','fb_link','company_id','package_id','remember_token'])]);
    }
    public function editUserProfile(Request $request)
    {

        $user = auth('api')->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required|digits:8|unique:users,mobile,' . $user->id,
            'country' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 200,
                'message' => implode("\n", $validator->messages()->all())]);
        }

        $name = ($request->has('name')) ? $request->get('name') : $user->name;
       $email = ($request->has('email')) ? $request->get('email') : $user->email;
        $mobile = ($request->get('mobile')) ? $request->get('mobile') : $user->mobile;
        $country = ($request->get('country')) ? $request->get('country') : $user->country;
        $user->name = $name;
        $user->mobile = $mobile;
        $user->email = $email;
        $user->country=$country;
        $user->save();

        if ($user) {

            if ($request->has('fcm_token')) {
                Token::updateOrCreate(['device_type' => $request->get('device_type'), 'fcm_token' => $request->get('fcm_token')], ['user_id' => $user->id]);
            }
            $user = User::query()->findOrFail($user->id);
            $user['access_token'] = $user->createToken('mobile')->accessToken;

            $message = ('ok');
            return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'user' => $user->makeHidden(['name','image','description','accept_pick_up','branch_name','opening_status','longitude','latitude','type'])]);
        } else {
            $message =('notedit');
            return response()->json(['status' => false, 'code' => 200,
                'message' => $message, 'validator' => $validator]);
        }
    }
    public function editViewerAccount(Request $request,$type){
        $user = auth('api')->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required|digits:8|unique:users,mobile,' . $user->id,
            'country' => 'required',
            'confirm_password'=> 'required',
            'password'=> 'required',
            'company'=> 'required',
            'files'=> 'required|file',
            'company_files'=> 'required|file',
            'fb_link'=> 'required|url',
            'tw_link'=> 'required|url',
            'inst_link'=> 'required|url',
            'linked_link'=> 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 200,
                'message' => implode("\n", $validator->messages()->all())]);
        }

        $name = ($request->has('name')) ? $request->get('name') : $user->name;
       $email = ($request->has('email')) ? $request->get('email') : $user->email;
        $mobile = ($request->get('mobile')) ? $request->get('mobile') : $user->mobile;
        $country = ($request->get('country')) ? $request->get('country') : $user->country;
        $password= ($request->get('password')) ? $request->get('password') : $user->country;
        $confirm_password= ($request->get('confirm_password')) ? $request->get('confirm_password') : $user->country;
        $company= ($request->get('company')) ? $request->get('company') : $user->country;
        $files= ($request->get('files')) ? $request->get('files') : $user->country;
        $company_files= ($request->get('company_files')) ? $request->get('company_files') : $user->country;
        $fb_link= ($request->get('fb_link')) ? $request->get('fb_link') : $user->country;
        $tw_link= ($request->get('tw_link')) ? $request->get('tw_link') : $user->country;
        $inst_link= ($request->get('inst_link')) ? $request->get('inst_link') : $user->country;
        $linked_link= ($request->get('linked_link')) ? $request->get('linked_link') : $user->country;
        $user->name = $name;
        $user->mobile = $mobile;
        $user->email = $email;
        $user->country=$country;
        $user->password=$password;
        $user->confirm_password=$confirm_password;
        $user->company=$company;
        $user->files=$files;
        $user->company_files=$company_files;
        $user->fb_link=$fb_link;
        $user->tw_link=$tw_link;
        $user->inst_link=$inst_link;
        $user->linked_link=$linked_link;
        $user->save();

        if ($user) {

            if ($request->has('fcm_token')) {
                Token::updateOrCreate(['device_type' => $request->get('device_type'), 'fcm_token' => $request->get('fcm_token')], ['user_id' => $user->id]);
            }
            $user = User::query()->findOrFail($user->id);
            $user['access_token'] = $user->createToken('mobile')->accessToken;

            $message = ('ok');
            return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'user' => $user->makeHidden(['name','image','description','accept_pick_up','branch_name','opening_status','longitude','latitude','type'])]);
        } else {
            $message =('notedit');
            return response()->json(['status' => false, 'code' => 200,
                'message' => $message, 'validator' => $validator]);
        }


    }
    public function maraadViewrDetails(User $user,Location_Maared $location_maarad){
        // if($user->type=='2'){
        //     $maarads=User::with('location_maarad')->where('location_maarad_id',)
        // }

    }
public function getAllUser(){
   return $users = User::with('location_maared')->get();
}




}




