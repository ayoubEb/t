<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Facture;
use App\Models\FacturePaiement;
use App\Models\LigneRapport;
use App\Models\RapportCrm;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\Activitylog\Models\Activity;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClientExample;
use App\Imports\ClientImport;
class ClientController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:client-list|client-nouveau|client-modification|client-suppression', ['only' => ['index','show']]);

    $this->middleware('permission:client-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:client-modification', ['only' => ['edit','update']]);

    $this->middleware('permission:client-suppression', ['only' => ['destroy']]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $clients = Client::all();
    $all = [ "clients" => $clients ];
    return view('clients.index',$all);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $liste_groupes = DB::table('groups')->select('id','nom','remise','deleted_at')->whereNull("deleted_at")->get();
    $type_clients   = DB::table('type_clients')->pluck("nom");
    $all = [
      'groupes' => $liste_groupes,
      "types"   => $type_clients,
    ];
    return view('clients.create',$all);
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
      "raison_sociale"  => ["required","not_regex:/^([a-z]+[0-9]+)|([A-Z]+[0-9]+)|([0-9]+)|([0-9]+[a-z]+)|([0-9]+[A-Z]+)$/"],
      "ville"           => ["nullable","not_regex:/^([a-z]+[0-9]+)|([A-Z]+[0-9]+)|([0-9]+)|([0-9]+[a-z]+)|([0-9]+[A-Z]+)$/"],
      "adresse"         => ["nullable"],
      "telephone"       => ["nullable","not_regex:/^([a-z]+)|([A-Z]+)|([A-Za-z]+)|([a-zA-Z]+)$/"],
      "ice"             => ["nullable", "digits_between:1,16","unique:clients,ice"],
      "if_client"       => ["nullable", "digits_between:1,16","unique:clients,if_client"],
      "rc"              => ["nullable", "digits_between:1,16","unique:clients,rc"],
      // "maxMontantPayer" => ["nullable", "numeric","min:0"],
      "email"           => ["nullable","unique:clients,email"],
      // "type"            => ["required","exists:type_clients,nom"],
      // "group_id"        => ["required","exists:groups,id"],
    ]);
    $count_clients = DB::table("clients")->count();
    $iden = "cli-0".($count_clients + 1) . Str::random(6);
    $client = Client::create([
      "identifiant"     => $iden,
      "raison_sociale"  => $request->raison_sociale,
      "adresse"         => $request->adresse ?? null,
      "email"           => $request->email ?? null,
      "ville"           => $request->ville ?? null,
      "ice"             => $request->ice,
      "code_postal"     => $request->code_postal ?? null,
      "telephone"       => $request->telephone ?? null,
      "ice"             => $request->ice,
      "if_client"              => $request->if_client ?? null,
      "montant"         => 0,
      "payer"           => 0,
      "reste"           => 0,
      "rc"              => $request->rc ?? null,
      "moisCreation"    => date("m-Y"),
      "dateCreation"    => Carbon::now(),
    ]);
    $ligneRapport= null;
    $ligneRapport_ex = LigneRapport::where("mois",$client->moisCreation)->exists();
    if($ligneRapport_ex == true){
      $ligne = LigneRapport::where("mois",$client->moisCreation)->first();
      $ligneRapport = $ligne;
    }
    else
    {
      $ligneRapport = LigneRapport::create([
        "num"=>Str::upper(Str::random(8)),
        "mois"=>$client->moisCreation,
      ]);
    }

    RapportCrm::create([
      "ligne_rapport_id" => $ligneRapport->id,
      "name"      => $client->raison_sociale,
      "identifiant"      => $client->identifiant,
      "jour"             => $client->dateCreation,
      "montant"          => $client->montant,
      "payer"            => $client->payer,
      "reste"            => $client->reste,
    ]);
    toast("L'enregistrement du client effectuée","success");
    return redirect()->route('client.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Client  $client
   * @return \Illuminate\Http\Response
   */
  public function show(Client $client)
  {
    $factures    = $client->factures()->get();
    $fac_ids     = Facture::where("client_id",$client->id)->pluck("id");
    $paiements   = FacturePaiement::whereIn("facture_id",$fac_ids)->get();
    $clients_suivi = Activity::where("log_name","client")->get();
    foreach($clients_suivi as $suivi){
      $suivi->user = User::find($suivi->causer_id)->first()->name;
    }
    $all = [
      "client"    => $client,
      "factures"  => $factures,
      "paiements"  => $paiements,
      "clients_suivi"  => $clients_suivi,
    ];

    return view("clients.show",$all);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Client  $client
   * @return \Illuminate\Http\Response
  */
  public function edit(Client $client)
  {
    $groupes = DB::table('groups')->select('id','nom','remise',"deleted_at")->whereNUll("deleted_at")->get();
    $types   = DB::table('type_clients')->pluck("nom");
    $all = [
      "client"  => $client,
      "groupes" => $groupes,
      "types"   => $types
    ];
      return view("clients.edit",$all);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Client  $client
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Client $client)
  {
    $request->validate([
      "raison_sociale"  => ["required","not_regex:/^([a-z]+[0-9]+)|([A-Z]+[0-9]+)|([0-9]+)|([0-9]+[a-z]+)|([0-9]+[A-Z]+)$/"],
      "ville"           => ["nullable","not_regex:/^([a-z]+[0-9]+)|([A-Z]+[0-9]+)|([0-9]+)|([0-9]+[a-z]+)|([0-9]+[A-Z]+)$/"],
      "adresse"         => ["nullable"],
      "telephone"           => ["nullable","not_regex:/^([a-z]+)|([A-Z]+)|([A-Za-z]+)|([a-zA-Z]+)$/"],
      'ice' => [
          "nullable", "digits_between:1,16",
          Rule::unique('clients', 'ice')->ignore($client->id),
      ],
      'if_client' => [
          "nullable", "digits_between:1,16",
          Rule::unique('clients', 'if_client')->ignore($client->id),
      ],
      'rc' => [
          "nullable", "digits_between:1,16",
          Rule::unique('clients', 'rc')->ignore($client->id),
      ],
      'email' => [
          "nullable","email",
          Rule::unique('clients', 'email')->ignore($client->id),
      ],
      "email"              => ["nullable"],
      "maxMontantPayer" => ["nullable", "numeric","min:0"],
      "type"              => ["nullable","exists:type_clients,nom"],
      "group_id"              => ["nullable","exists:groups,id"],

    ]);

    $client->update([
      "raison_sociale"  => $request->raison_sociale,
      "adresse"         => $request->adresse ?? null,
      "email"           => $request->email ?? null,
      "ville"           => $request->ville ?? null,
      "ice"             => $request->ice ?? null,
      "rc"              => $request->rc ?? null,
      "email"           => $request->email ?? null,
      "if_client"              => $request->if_client ?? null,
      "code_postal"     => $request->code_postal ?? null,
      "telephone"       => $request->telephone ?? null,
    ]);
    toast("La modification du client effectuée","success");
    return redirect()->route('client.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Client  $client
   * @return \Illuminate\Http\Response
   */
  public function destroy(Client $client,Request $request)
  {

    $client->delete();
    toast("La déplacement du corbeille du client effectuée","success");
    return back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Client  $client
   * @return \Illuminate\Http\Response
   */
  public function rapportDocument(Client $client)
  {
    $commandes           = $client->factures()->get();
    $ht                  = $client->factures()->sum("ht");
    $net_payer           = $client->factures()->sum("net_payer");
    $reste               = $client->factures()->sum("reste");
    $payer               = $client->factures()->sum("payer");
    $fac_ids             = Facture::where("client_id",$client->id)->pluck("id");
    $paiements           = FacturePaiement::whereIn("facture_id",$fac_ids)->get();
    $commande_livraisons = Facture::whereIn("id",$fac_ids)->where("etat_livraison",1)->get();
    $commande_retards    = Facture::whereIn("id",$fac_ids)->where("datePaiement","<",Carbon::today())->get();
    foreach($commande_retards as $cmd_retard)
    {
      $start = Carbon::parse($cmd_retard->datePaiement);
      $end =  Carbon::parse($cmd_retard->date_facture);

      $cmd_retard->nbr_days = $end->diffInDays($start);
    }
    $all = [
      "client"              => $client,
      "commandes"           => $commandes,
      "paiements"           => $paiements,
      "commande_livraisons" => $commande_livraisons,
      "commande_retards"    => $commande_retards,
      "ht"                  => $ht,
      "net_payer"           => $net_payer,
      "reste"               => $reste,
      "payer"               => $payer,
    ];
    $pdf = Pdf::loadview('clients.rapportDocument',$all);
    return $pdf->stream("rapport:". $client->identifiant);
  }


    public function example(){
        $data = [
          ['nomX' , "iceX" , ""],
          ['nomY' , "iceY" , ""],
          ['nomZ' , "iceZ" , ""],
        ];
        return Excel::download(new ClientExample($data), 'example_clients.xlsx');
    }


  public function import( Request $request )
  {
    $import = new ClientImport();
    Excel::import($import, $request->file);
      toast("L'importation de fiche excel effectuée" , "success");
      return back();


  }

}
