<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Blog;
use App\Models\Company;
use App\Models\About;
use App\Models\Location_Work;
use App\Models\Package;
use App\Models\Event;
use App\Models\Day;
use App\Models\Location;
use App\Models\Location_Maared;
use App\Models\Question;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Maared;

class AppController extends Controller
{
    public function storeBlogs(Request $request){
        $validator = Validator::make($request->all(), [
            'image'=>'required|file',
            'name_maraad'=>'required',
            'date'=>'required|date',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 200,
                'message' => implode("\n",$validator-> messages()-> all()) ]);
        }
        $item = new Blog();
        $item->image = $request->get('image');
        $item->name_maraad = $request->get('name_maraad');
        $item->date = $request->get('date');
        $item->save();
        $message = ('done_successfully');
        return response()->json(['status' => true,  'message' => $message, 'item'=>$item ]);
    }
    public function Blog(Request $request,$id){
       
        $item = Blog::query()->findOrFail($id);
        $message = ('ok');
        return response()->json(['status' => true, 'code' => 200,
            'message' => $message, 'item' => $item]);
    }
    
    public function storeCompany(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'image'=>'required|file',
            'user_id'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 200,
                'message' => implode("\n",$validator-> messages()->all()) ]);
        }
        $item=new Company();
        $item->user_id=auth('api')->id();
        $item->name=$request->get('name');
        $item->image=$request->file('image');
        $item->save();
       return response()->json(['status' => true, 'code' => 200, 'message' =>'created successfuly', 'items' => $item->makeHidden(['created_at','updated_at'])]);
        
    }
    public function companyViewerDetails(User $user){

        $user=User::where('type', '3')->with('company.location_works')->first();
        return response()->json(['status' => true, 'code' => 200, 'message' =>'created successfuly', 'items' => $user]);
    
}
public function companyRaeiDetails(){
    $user=User::where('type', '2')->with('company.location_works')->first();
   
    return response()->json(['status' => true, 'code' => 200, 'message' =>'created successfuly', 'items' => $user]);

}
public function companyOrganizerDetails(){
    $user=User::where('type', '4')->with('company.location_works')->first();
   
    return response()->json(['status' => true, 'code' => 200, 'message' =>'created successfuly', 'items' => $user]);

}
public function companyPackageRaeiDetails(){
    $user=User::where('type','2')->with('company.packages')->first();
    return response()->json(['status' => true, 'code' => 200, 'message' =>'created successfuly', 'items' => $user]);

}
public function companyPackageViewerDetails(){
    $user=User::where('type','3')->with('company.packages')->first();
    return response()->json(['status' => true, 'code' => 200, 'message' =>'created successfuly', 'items' => $user]);

}
    public function packageUser($id){
        $packages=Package::where('user_id',$id)->first();
        return response()->json(['status' => true, 'code' => 200, 'message' =>'created successfuly', 'items' => $packages]);
    }
    public function storeEvents(Request $request){
       
        $request->validate([
            'day_id'=>'required',
            'name'=>'required',
            'time'=>'required'
        ]);
        $item=new Event();
        $item->day_id=$request->day_id;
        $item->name=$request->name;
        $item->time=$request->time;
        $item->save();
       return response()->json(['status' => true, 'code' => 200, 'message' =>'created successfuly', 'items' => $item]);

    }
    public function storeDays(Request $request){
        $request->validate([
            'name'=>'required'

        ]);
        $item=new Day();
        $item->name=$request->name;
        $item->save();
        return response()->json(['status' => true, 'code' => 200, 'message' =>'created successfuly', 'items' => $item]);

    }
    public function viewDayEvents(){
       $event=Event::pluck('id');
       $days = Day::with('events')->where('id', '=', $event)->firstOrFail();
       return response()->json([
           'status' => 200,
           'days' => $days,
       ]);
    }
    public function storeQuestionAnswers(Request $request){
        $request->validate([
            'nameofquestion'=>'required',
            'answer'=>'required|array'
        ]);
        $item=new Question();
        $item->nameofquestion=$request->nameofquestion;
        $item->answer=$request->answer;
        $item->save();
        return response()->json([
            'status' => 200,
            'question_answer' => $item,
        ]);
    }
    public function viewQuestionAnswers(){
        $ques=Question::all();
        return response()->json([
            'status' => 200,
            'question_answers' => $ques,
        ]);
    }
    public function storeAbout(Request $request){
       
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'image'=>'required',
            'date'=>'required',
        ]);
        $item=new About();
        $item->name=$request->name;
        $item->description=$request->description;
        $item->image=$request->image;
        $item->date=$request->date;
        $item->save();
        return $item;
        return response()->json([
            'status' => 200,
            'about' => $item,
        ]);
    }
    public function viewAbout(){
        $abouts=About::all();
        return response()->json([
            'status' => 200,
            'about' => $abouts,
        ]);
    }
    public function storeTicket(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'date'=>'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 200,
                'message' => implode("\n",$validator-> messages()-> all()) ]);
        }
        $item=new Ticket ();
        $item->user_id=auth('api')->id();
        $item->name=$request->get('name');
        $item->date=$request->get('date');
        $item->save();
        return response()->json([
            'status' => 200,
            'tickets' => $item,
        ]);
    }
    public function viewTicketsUser($id){
        $tickets=Ticket::where('user_id',$id)->first();
        return response()->json([
            'status' => 200,
            'tickets' => $tickets,
        ]);
    }
    public function allTickets(){
        $tickets=Ticket::all();
        return response()->json([
            'status' => 200,
            'tickets' => $tickets,
        ]);
    }
    public function storePackage(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'package'=>'required|file',
            'description'=>'required',
            'user_id'=>'required',
            'company_id'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 200,
                'message' => implode("\n",$validator-> messages()-> all()) ]);
        }
        $item=new Package();
        $item->name=$request->get('name');
        $item->package=$request->file('package');
        $item->description=$request->get('description');
        $item->user_id=$request->get('user_id');
        $item->company_id=$request->get('company_id');
        $item->save();
       return response()->json(['status' => true, 'code' => 200, 'message' =>'created successfuly', 'items' => $item]);
    }
    public function ViewerMaarad(Location_Maared $location_maared){
        $item=User::with('location_maared')->where('location_maared_id',$location_maared->id);

    }
    public function storeMaaradByViewer(Request $request,User $user){
       
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'location'=>'required|file',
            'area'=>'required',
            'logo'=>'required',
            'imagemarad'=>'required',
            'description'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 200,
                'message' => implode("\n",$validator-> messages()-> all()) ]);
        }
        if ($user->has('location_maared')){
        $item=new Location_Maared();
        $item->name=$request->get('name');
        $item->package=$request->get('location');
        $item->description=$request->get('area');
        $item->save();
        }
       return response()->json(['status' => true, 'code' => 200, 'message' =>'created successfuly', 'items' => $item]);
    }
    public function getMaraad(){
        $users=User::with('location_maared')->where('type','4')->get();
        return response()->json([
            'user'=>$users

        ]);
    }
        public function maraadViewrDetails(User $user){
            if($user->type=='4'){
               $maarads=Location_Maared::with(['user'])->where('user_id',$user->id)->get();
               return response()->json([
                'details'=>$maarads->makeHidden(['user_id','password','confirm_password','created_at','updated_at','email_verified_at','package_id','service','company_id','tw_link','inst_link','linked_link','bio','type','files','company_files']),
                
            ]);
            }
            else{
            return response()->json([
                'details'=>'the type is not valid here',
                
            ]);
        }
    }
    public function organizerDetails(){
    
            $organizers=User::where('type','2')->get();
            return response()->json([
                'organizers'=>$organizers->makeHidden(['company_id','package_id','type','company_files','files','country','company','confirm_password','password','email_verified_at','updated_at','created_at','remember_token','linked_link','inst_link','tw_link','fb_link']),
            ]);

        }
        public function packagesBelongMaared(){
            $packages=Maared::with('packages')->get();
            return response()->json([
                'packages'=>$packages
    
            ]);
        }
        public function storeLocationWorks(Request $request){
            $validator = Validator::make($request->all(), [
                'number'=>'required',
                'area'=>'required',
                'company_id'=>'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'code' => 200,
                    'message' => implode("\n",$validator-> messages()-> all()) ]);
            }
        $item=new Location_Work();
        $item->number=$request->number;
        $item->area=$request->area;
        $item->company_id=$request->company_id;
        $item->save();
        return response()->json([
            'status' => 200,
            'location_works' => $item,
        ]);

        }
        public function storeLocationMaarad(Request $request){
            $validator = Validator::make($request->all(), [
                'location'=>'required',
                'area'=>'required',
                'location_maarad_id'=>'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'code' => 200,
                    'message' => implode("\n",$validator-> messages()-> all()) ]);
            }
        $item=new Location();
        $item->location=$request->location;
        $item->area=$request->area;
        $item->location_maarad_id=$request->location_maarad_id;
        $item->save();
        return response()->json([
            'status' => 200,
            'locations' => $item,
        ]);

        }

   
    


    

    
}