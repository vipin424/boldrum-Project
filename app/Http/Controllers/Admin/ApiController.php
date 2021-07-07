<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\Admin\Role;
use App\Models\Admin\User_role;
use App\Models\Admin\Ballroom_item;
use App\Models\Admin\Order;
use App\Models\Admin\Order_detail;
use App\Models\User;

class ApiController extends Controller
{
 // homeapi List api Controller---
    function get_roles(){
  $roles_data=Role::all();
    return response()->json([
        'Msg'=>'Success',
        'Count'=>1,
        'Roles_list'=>$roles_data,
    ]);
}
// user login api
function Userlogin(Request $request){
    $user=User::where('email',$request->email)->first();
    $data=DB::table('roles')
    ->join('users', 'users.role_id','=','roles.id')
    ->select('roles.role_name')
    ->where('role_id',$user->role_id)->value('role_name');
    if(!$user ||!Hash::check($request->password,$user->password)){
        return response()->json([
            'msg'=>'Incorrect Email or Password!!',
            'Count'=>0,
            ]);
    }else{
        return response()->json([
            'msg'=>'Success',
            'Count'=>1,
             "Userid"=>$user->id,
             "Rolename"=>$data,
             "Username"=>$user->name,
            ]);
    }
  
}
function homePage(Request $request){
    $data=DB::table('users')
    ->select('users.ball_id')
    ->where('id',$request->id)->value('name');
    $string = $data;
    $integerIDs = array_map('intval', explode(',', $string));
    $items = DB::table('Ballrooms')->whereIn('id',$integerIDs)->get();
    return response()->json([
        'msg'=>'Success',
        'Count'=>1,
        "dashboard_page"=>$integerIDs
        ]);
}

function club_material(Request $req){
    $data=DB::table('club_materials')
    ->join('clubs', 'clubs.id','=','club_materials.club_id')
    ->select('club_materials.material_id','club_materials.club_id')
    ->where('club_materials.id',$req->id)->get();
    $string = $data;
    $integerID = array_map('intval', explode(',', $string));
    $items=DB::table('materials')->whereIn('id',$integerID)->get();
    return response()->json([
        'msg'=>'Success',
        'Count'=>1,
        "Material_list"=>$items
        ]);
}

function orders(Request $req){
    $userData=new Order;
    $userData->user_id=$req->user_id;
    $userData->creation_date=$req->creation_date;
    $userData->status="pending";
    $userData->message=$req->message;
    $userData->ballroom_id=$req->ballroom_id;
    $userData->material_id=$req->material_id;
    $userData->quantity=$req->quantity;
    $userData->save();
    return response()->json([
        'msg'=>'Success',
        'Count'=>1,
        "Orders"=>$userData
        ]);
}
function material_orders(Request $req){
    $new = Order::find($req->id);
    $new->status=$req->status;
    $new->save();
    $orders = Order::where(['id' => $req->id])->value('quantity');
    $newTask = Order::find($req->id)->get();

    foreach($newTask as $data){
        $orderDetail = Order_detail::where(['material_id' => $data->material_id, 
        'ballroom_id' => $data->ballroom_id])->first();
        if($orderDetail){
            $orderDetail->material_id=$data->material_id;
            $orderDetail->ballroom_id=$data->ballroom_id;
            $orderDetail->quantity=$data->quantity+$orders;
            $orderDetail->save();
        }else{
   $data= DB::table('order_details')->insert([
        'material_id' =>$data->material_id,
        'quantity' => $data->quantity,
        'ballroom_id' => $data->ballroom_id, 
        'status'=>$data->status,
        'user_id'=>$data->user_id,
        'message'=>$data->message,
        'creation_date'=>$data->creation_date,
    ]);
}
}
    return response()->json([
        'Approved_order'=>$data,
        'msg'=>'Success',
        ]);

}


function ballroom_details(Request $request){
    $data=DB::table('order_details')
    ->join('materials', 'materials.id','=','order_details.material_id')
    ->select('order_details.id','order_details.user_id','order_details.creation_date','order_details.quantity','order_details.status','order_details.message','order_details.ballroom_id','materials.mat_name','materials.mat_image',
    'materials.icon','materials.supplier','materials.price')
    ->where('user_id',$request->user_id)
    ->where('ballroom_id',$request->ballroom_id)
    ->where('status','success')
    ->get();
    $dat=DB::table('orders')
    ->join('materials', 'materials.id','=','orders.material_id')
    ->select('orders.id','orders.user_id','orders.creation_date','orders.status','orders.quantity','orders.message','orders.ballroom_id','materials.mat_name','materials.mat_image',
    'materials.icon','materials.supplier','materials.price')
    ->where('user_id',$request->user_id)
    ->where('ballroom_id',$request->ballroom_id)
    ->where('status','pending')
    ->get();
    if($request->status='success'){
        $data;
    }else{
        $dat;
    }
    return response()->json([
        'msg'=>'Success',
        'Count'=>1,
        "Available_stock"=>$data,
        'Pending_stock'=>$dat
        ]);
}
function approve_List(){
    $getorder=DB::table('orders')
    ->join('materials', 'materials.id','=','orders.material_id')
    ->join('users', 'users.id','=','orders.user_id')
    ->join('ballrooms', 'ballrooms.id','=','orders.ballroom_id')
    ->select('orders.id','orders.creation_date','orders.quantity','orders.status','orders.message','users.name as user_name','ballrooms.name as ballroom_name','materials.mat_name as material_name','materials.mat_image',
    'materials.icon as material_icon','materials.supplier','materials.price')
    ->where('status','pending')
    ->get();
    return response()->json([
        'msg'=>'Success',
        'Count'=>1,
        "Approved_list"=>$getorder
        ]);
}
function Get_profile(Request $req){
    $imageName = '';
    if($req->profile_picture){
    $imageName = date('YmdHis') . "." . $req->profile_picture->getClientOriginalExtension();
    $req->profile_picture->move(public_path('upload'),$imageName);

     $profile=User::find($req->id);
     $profile->id=$req->id;
     $profile->profile_picture=$imageName;
     $profile->save();
     return response()->json([
        "Msg"=>"Success",
        "Count"=>1,
        "user_id"=>$req->id,
        "profile_picture"=>$profile->profile_picture,
      ]);

    }  
 }

 function Get_user(Request $request){
    $userData=User::find($request->id);
    $clubname=DB::table('users')
    ->join('clubs', 'clubs.id','=','users.club_id')
    ->select('clubs.club_name')
    ->where('club_id',$userData->club_id)->value('club_name');
    $rolename=DB::table('users')
    ->join('roles', 'roles.id','=','users.role_id')
    ->select('roles.role_name')
    ->where('role_id',$userData->role_id)->value('role_name');
    return response()->json([
        "Msg"=>"Success",
        "Count"=>1,
        "user_id"=>$request->id,
        "username"=>$userData->name,
        "email"=>$userData->email,
        "password"=>$userData->password,
        "clubname"=>$clubname,
        "rolename"=>$rolename,
        "profile_picture"=>$userData->profile_picture,
      ]);
 }
}
