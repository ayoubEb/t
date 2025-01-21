<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:user-list|user-nouveau|user-modification|user-suppression', ['only' => ['index']]);
         $this->middleware('permission:user-nouveau', ['only' => ['create','store']]);
         $this->middleware('permission:user-modification', ['only' => ['edit','update']]);
         $this->middleware('permission:user-suppression', ['only' => ['destroy']]);
    }
    public function index(){
        $users = User::select("id","email","username","role","statut","name")->where("id",'<>',Auth::user()->id)->get();
        $roles = Role::pluck('name','name')->all();
        return view("grh.users",[
            'users'=> $users,
            "roles"=>$roles
        ]);
    }


    public function create(){

    }

    public function store(Request $request){
     $request->validate([
        'name'=>['required'],
        'email'=>['required','unique:users,email'],
        'password'=>['min:8','confirmed'],
        "roles"=>["required"],
        "username"=>["required",'unique:users,username']

      ]);

    if(!empty($request->name) ||!empty($request->email) || !empty($request->password) || !empty($request->roles)){
        $user = User::create([
            "image"=>"user.jpg",
            "name"=>$request->name,
            "username"=>$request->username,
            "email"=>$request->email,
            "statut"=>"activer",
            "role"=>$request->fonction ?? "user",
            "password"=>Hash::make($request->password),

        ]);
        $user->assignRole($request->input('roles'));
        toast("L'enregistrement d'utilisateur effectuée","success");
    }
    else{
        toast("Remplir en tous les champs obligatoire","success");

    }
        return back();

    }
    public function show($id)
    {

    }

    public function edit($id){
    //   $edit_user = User::find($id);
    //   $roles = Role::pluck('name','name')->all();
    //   $userRole = $edit_user->roles->pluck('name','name')->all();
    //   return view('user.edit',['edit_user'=>$edit_user,'roles'=>$roles,'userRole'=>$userRole]);
    }

    public function update(Request $request,User $user){

      $request->validate([
        'name_u'=>['required'],
        'email_u'=>['required'],
        'username_u'=>['required'],
        'roles_u' => ['required'],

      ]);
      if($request->password_u != null ){
        $request->validate([ 'password_u' => ['string', 'min:8', 'confirmed'] ]);
        // $user->password = Hash::make($request->password_u);
      }
      $user->update([
        "name"=>$request->name_u,
        "username"=>$request->username_u,
        "role"=>$request->fonction_u ?? "user",
        "email"=>$request->email_u,
        // "statut"=>$request->statut_u,
        "password"=>$request->password_u ?? "",
      ]);
          DB::table('model_has_roles')->where('model_id',$user->id)->delete();
        $user->assignRole($request->input('roles_u'));
        toast("La motification d'utilisateur effectuée","success");
        return redirect()->back();

  }

  public function destroy(User $user){

    $user->delete();
    toast("La déplacement du corbeille d'utilisateur effectuée","success");
    return back();
  }
}
