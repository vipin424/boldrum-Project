<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\club;
use App\Models\Admin\Role;
use App\Models\Admin\Ballroom;
use App\Models\Admin\Material;
use App\Models\Admin\Club_Material;
use App\Models\User;
class AdminController extends Controller
{
    //
    function index(){
        return view('Admin.layout.index');
    }

    function get_clubs(){
        $data=club::all();
        return view('Admin.clubs',['items'=>$data]);
    }
    function add_clubs(){
        return view('Admin.addclub');
    }
    function Insert_clubs(Request $request){
        $request->validate([
            'name'=>'required',
            'phone'=>'required|max:10',
            'address1'=>'required',
            'address2'=>'required',
            'city'=>'required',
            'zipcode'=>'required|max:6',
            'website'=>'required',
            'cvr'=>'required|max:8',
            'logo'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $upcomingImage = '';
        if($request->logo){
        $upcomingImage = date('YmdHis') . "." . $request->logo->getClientOriginalExtension();
        $request->logo->move(public_path('upload'),$upcomingImage);

        $data= new club;
        $data->club_name=$request->name;
        $data->phone=$request->phone;
        $data->address1=$request->address1;
        $data->address2=$request->address2;
        $data->city=$request->city;
        $data->zipcode=$request->zipcode;
        $data->website=$request->website;
        $data->cvr=$request->cvr;
        $data->logo=$upcomingImage;
        $data->save();
        return redirect('/add-club');
    }
}
function Deleteclub($id){
    $data=club::find($id);
    $data->delete();
    return redirect()->back()->with('success','Your Club has been Deleted!!');
}

function get_user(){
    $data = DB::table('users')
    ->join('clubs', 'clubs.id', '=', 'users.club_id')
    ->join('roles', 'roles.id', '=', 'users.role_id')
    ->select('users.*','clubs.club_name','roles.role_name')
    ->get();
    return view('Admin.user',['items'=>$data]);
}
function add_user(){
    $users=club::all();
    $roles=Role::all();
    $balls=Ballroom::all();
    return view('Admin.adduser',compact('users','roles','balls'));
}
function Insert_user(Request $request){
    $users = User::where('email', '=', $request->input('email'))->first();
    if ($users === null) {
    $request->validate([
        'club_id'=>'required',
        'role_id'=>'required',
        'name'=>'required',
        'email'=>'required|email|unique:users,email|regex:/(.+)@(.+)\.(.+)/i',
        'password'=>'required|max:6',
        'creation_date'=>'required|date',
        'profile_picture'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    ]);
    $upcomingImage = '';
    if($request->profile_picture){
    $upcomingImage = date('YmdHis') . "." . $request->profile_picture->getClientOriginalExtension();
    $request->profile_picture->move(public_path('upload'),$upcomingImage);

    $news = $request->input('ball_id');
    $news = implode(',', $news); 

    $data= new User;
    $data->club_id=$request->club_id;
    $data->role_id=$request->role_id;
    $data['ball_id'] = $news;
    $data->name=$request->name;
    $data->email=$request->email;
    $data->password=hash::make($request->password);
    $data->creation_date=$request->creation_date;
    $data->profile_picture=$upcomingImage;
    $data->user_status="Activate";
    $data->save();
    return redirect('/user')->with('success','User has been added!!');
}
    }else{
        return redirect()->back()->with('error','User Already Exist!!');
    }
}

function Deleteuser($id){
    $data=User::find($id);
    $data->delete();
    return redirect()->back()->with('success','Your User has been Deleted!!');
}

function get_roles(){
    $data=Role::all();
    return view('Admin.roles',['items'=>$data]);
}

function Insert_roles(Request $request){
    $request->validate([
        'name'=>'required',
    ]);
    $data= new Role;
    $data->role_name=$request->role_name;
    $data->save();
    return redirect('/roles');
}

function get_ballrooms(){
    $data=Ballroom::all();
    return view('Admin.ballrooms',['items'=>$data]);
}

function add_ballroom(){
    return view('Admin.addballroom');
}
function Insert_ballroom(Request $req){
    $data= new Ballroom;
    $data->name=$req->name;
    $data->owner=$six_digit_random_number = mt_rand(100000000, 999999999);
    $data->creation_date=$req->creation_date;
    $data->save();
    return redirect('/ballrooms')->with('success','Ballroom has been added!!');
}
function Deleteballroom($id){
    $data=Ballroom::find($id);
    $data->delete();
    return redirect()->back()->with('success','Ballroom has been Deleted!!');
}


function get_material(){
    $data=Material::all();
    return view('Admin.materials',['materials'=>$data]);
}

function add_material(){
    return view('Admin.addmaterial');
}
function Insert_material(Request $req){
    $req->validate([
        'mat_name'=>'required',
        'price'=>'required',
        'supplier'=>'required',
        'mat_image'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        'icon'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    ]);
    $materialImage = '';
    if($req->mat_image){
    $materialImage = date('YmdHis') . "." . $req->mat_image->getClientOriginalExtension();
    $req->mat_image->move(public_path('upload'),$materialImage);

    $materialIcon = '';
    if($req->icon){
    $materialIcon = date('YmdHis') . "." . $req->icon->getClientOriginalExtension();
    $req->icon->move(public_path('upload'),$materialIcon);

    $data= new Material;
    $data->mat_name=$req->mat_name;
    $data->price=$req->price;
    $data->supplier=$req->supplier;
    $data->mat_image=$materialImage;
    $data->icon=$materialIcon;
    $data->save();
    return redirect('/materials')->with('success','Material has been added!!');
    }
    }
}


function club_material(){
    $data=DB::table('club_materials')
    ->join('clubs', 'clubs.id','=','club_materials.club_id')

    ->select('club_materials.material_id','clubs.club_name')
    ->get();
    $string= $data;
    $integerID = array_map('intval', explode(',', $string));
    $items=DB::table('materials')->whereIn('id',$integerID)->get();

    return view('Admin.clubmaterial',['materials'=>$items]);
}
 function get_cmaterial(){
    $clubs=club::all();
    $mats=Material::all();
     return view('Admin.addcmaterial',compact('clubs','mats'));
 }
 function Insert_cmaterial(Request $req){
    $req->validate([
        'club_id'=>'required',
        'material_id'=>'required',
    ]);
    $material = $req->input('material_id');
    $material = implode(',', $material); 

    $data= new Club_Material;
    $data->club_id=$req->club_id;
    $data['material_id'] = $material;
    $data->save();
     return redirect('/club-material')->with('success','Add Club Material has been Successfully');
 }
 function DeleteMaterial($id){
    $data=Material::find($id);
    $data->delete();
    return redirect()->back()->with('success','Material has been Deleted!!');
}
}
