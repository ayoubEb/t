<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\reponse;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Models\Activity;

class GroupController extends Controller
{
  function __construct()
  {

    $this->middleware('permission:groupe-list', ['only' => 'index']);

    $this->middleware('permission:groupe-nouveau', ['only' => 'store']);

    $this->middleware('permission:groupe-modification', ['only' => 'update']);

    $this->middleware('permission:groupe-suppression', ['only' => 'destroy']);

    $this->middleware('permission:groupe-display', ['only' => 'show']);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $groups = Group::select("id","nom","remise","statut")->get();
    $all    = [ "groupes" => $groups ];
    return view('groupes.index',$all );
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('groupes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        "nom"    => ["required","unique:groups,nom"],
        "remise" => ['nullable','numeric','min:0' , 'max:100']
      ]);
      Group::create([
        "nom"    => $request->nom,
        "remise" => $request->remise ?? 0,
        "statut" => $request->statut == 1 ? 1 : 0,
      ]);

        toast("L'enregistrement du group effectuée","success");
        return redirect()->route('group.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
      $suivi_actions = Activity::where("log_name","groupe")->where("subject_id",$group->id)->get();
      foreach($suivi_actions as $suivi_action){
        $check_user = User::where('id',$suivi_action->causer_id)->exists();
        if($check_user == true)
        {
          $suivi_action->user = User::find($suivi_action->causer_id)->first()->name;
        }
        else
        {
          $suivi_action->user = null;
        }
      }
      $all = [
        "group"=>$group,
        "suivi_actions"=>$suivi_actions
      ];
      return view("groupes.show",$all);
    }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Group  $group
   * @return \Illuminate\Http\Response
   */
  public function edit(Group $group)
  {
    $all =  [ "group" => $group ];
    return view("groupes.edit",$all);
  }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
      $request->validate([

          'nom' => [
            "required",
            Rule::unique('groups', 'nom')->ignore($group->id),
          ],

        "remise" => ['required','numeric','min:0' , 'max:100']
      ]);
      $group->update([
        "nom"    => $request->nom,
        "remise" => $request->remise,
        "statut" => $request->statut == 1 ? 1 : 0,
      ]);
      toast("La modification du group effectuée","success");
      return redirect()->route("group.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        toast("La suppression du group effectuée","success");
        return back();
    }




}
