<?php

namespace App\Http\Controllers;

use App\Models\TypeClient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Models\Activity;

class TypeClientController extends Controller
{
  function __construct()
  {

    $this->middleware('permission:typeClient-list', ['only' => 'index']);

    $this->middleware('permission:typeClient-nouveau', ['only' => 'store']);

    $this->middleware('permission:typeClient-modification', ['only' => 'update']);

    $this->middleware('permission:typeClient-suppression', ['only' => 'destroy']);

    $this->middleware('permission:typeClient-display', ['only' => 'show']);
  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $type_clients = TypeClient::select("id",'nom','statut',"created_at")->get();
      $all          = [ "type_clients" => $type_clients ];
      return view("typeClients.index",$all);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view("typeClients.create");
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
      "nom"=>["required","unique:type_clients,nom"],
    ]);
    TypeClient::create([
      "nom"=>$request->nom,
      "statut"=>$request->statut == 1 ? 1 : 0
    ]);
    toast("L'enregistrement du type client effectuée","success");
    return redirect()->route('typeClient.index');
  }


  /**
   * Display the specified resource.
   *
   * @param  \App\Models\TypeClient  $typeClient
   * @return \Illuminate\Http\Response
   */
  public function show(TypeClient $typeClient)
  {
    $suivi_actions = Activity::where("log_name","groupe")->where("subject_id",$typeClient->id)->get();
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
      "typeClient"=>$typeClient,
      "suivi_actions"=>$suivi_actions
    ];
    return view("typeClients.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\TypeClient  $typeClient
   * @return \Illuminate\Http\Response
   */
  public function edit(TypeClient $typeClient)
  {
    $all          = [ "typeClient" => $typeClient ];
    return view("typeClients.edit",$all);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\TypeClient  $typeClient
   * @return \Illuminate\Http\Response
  */
  public function update(Request $request, TypeClient $typeClient)
  {
    $request->validate([
      'nom' => [
        "required",
        Rule::unique('type_clients', 'nom')->ignore($typeClient->id),
      ],
    ]);
    $typeClient->update([
      "nom"=>$request->nom,
      "statut"=>$request->statut == 1 ? 1 : 0
    ]);
    toast("La modification du type client effectuée","success");
    return redirect()->route('typeClient.index');
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeClient  $typeClient
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeClient $typeClient)
    {
        $typeClient->delete();
        toast("La suppression du type client effectuée","success");
        return back();
    }
}
