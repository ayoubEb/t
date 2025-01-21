<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


;

class ProfilController extends Controller
{
//     public function __construct()
//     {
//         $this->middleware('auth');
//     }
    public function show(User $profil)
    {

        foreach($profil->roles as $row){
            $row->pemrissions = DB::table("role_has_permissions")
                ->join("roles","role_has_permissions.role_id","=","roles.id")
                ->join("permissions","role_has_permissions.permission_id","=","permissions.id")
                ->select("permissions.*","role_has_permissions.role_id")
                ->where("role_has_permissions.role_id",$row->id)
                ->get();
        }

      return view('mon-compte.profil',
      [
        'user'=>$profil,
        "row"=>$row
      ]);
    }

    public function edit(User $profil){
      return view('mon-compte.preference',['user'=>$profil]);
    }

    public function update(Request $request,User $profil){

        $request->validate([
            'name'=>['required'],
            'username'=>['required'],
          ]);

          $profil->update([
            "name"=>$request->name,
            "email"=>$request->email,
            "role"=>$request->fonction ?? "manager",
            "username"=>$request->username,
            // "password"=>$request->password ?? "",
          ]);
          toast("La motification du profil effectuée","success");
          return back();

  }
    public function updatePwd(Request $request,User $profil){

        $request->validate( ['password' => ['string', 'confirmed']]);
        //   if($request->password_u != null ){
        //     $request->validate([ 'password_u' => ['string', 'min:8', 'confirmed'] ]);
        //   }
          $profil->update([
            "password"=>Hash::make($request->password),
          ]);
        toast("La motification du mot de passe effectuée","success");
        return back();

  }
}
