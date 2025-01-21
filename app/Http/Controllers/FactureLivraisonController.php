<?php

namespace App\Http\Controllers;

use App\Models\FactureLivraison;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\CustomizeReference;
use App\Models\Entreprise;
use App\Models\Facture;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FactureLivraisonController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  function __construct()
  {
    $this->middleware('permission:factureLivraison-list|factureLivraison-nouveau|factureLivraison-modification|factureLivraison-suppression|factureLivraison-display', ['only' => ['index']]);

    $this->middleware('permission:factureLivraison-nouveau', ['only' => ['create','store']]);

    $this->middleware('permission:factureLivraison-modification', ['only' => ['edit','update','annuler']]);

    $this->middleware('permission:factureLivraison-suppression', ['only' => ['destroy']]);

    $this->middleware('permission:factureLivraison-display', ['only' => ['show']]);

  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $factureLivraisons = FactureLivraison::all();
    $all        = [ "factureLivraisons" => $factureLivraisons ];
    return view("factureLivraisons.index",$all);
  }

  public function add($id)
  {
    $facture = DB::table('factures')->where("id",$id)->first();
    if($facture->statut == "validé" && !isset($facture->adresse_livraison))
    {
      $livraisons = DB::table("livraisons")->get();
      $all = [
        "facture"         => $facture,
        "livraisons" => $livraisons,
      ];
      return view("factureLivraisons.add",$all);
    }
    else
    {
      return back();
    }
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
        "price"          => ["required",'numeric','min:0'],
        "adresse"        => ["required"],
        "statut"         => ["required"],
        "date_livraison" => ['required'],
        "livraison_id"   => ['required',"exists:livraisons,id"],
      ]);
      // format référence livraison
      $count_livraison = DB::table("factures")->where("etat_livraison",1)->count();
      $num_livraison        = CustomizeReference::where("champ","num_livraison")->where("affecter","livraison")->where("operation","vente")->first()->valeur;
      $separateur_livraison = CustomizeReference::where("champ","séparateur")->where("affecter","livraison")->where("operation","vente")->first()->valeur;
      $nbrZero_livraison    = CustomizeReference::where("champ","nombre_zero")->where("affecter","livraison")->where("operation","vente")->first()->valeur;
      $counter_livraison    = CustomizeReference::where("champ","counter")->where("affecter","livraison")->where("operation","vente")->first()->valeur;
      $reference      = $num_livraison . $separateur_livraison . str_pad($count_livraison + $counter_livraison, $nbrZero_livraison, "0", STR_PAD_LEFT);

      // format référence bon livraison
      $num_bon        = CustomizeReference::where("champ","num_bon")->where("affecter","bon_livraison")->where("operation","vente")->first()->valeur;
      $separateur_bon = CustomizeReference::where("champ","séparateur")->where("affecter","bon_livraison")->where("operation","vente")->first()->valeur;
      $nbrZero_bon    = CustomizeReference::where("champ","nombre_zero")->where("affecter","bon_livraison")->where("operation","vente")->first()->valeur;
      $counter_bon    = CustomizeReference::where("champ","counter")->where("affecter","bon_livraison")->where("operation","vente")->first()->valeur;
      $reference      = $num_bon . $separateur_bon . str_pad($count_livraison + $counter_bon, $nbrZero_bon, "0", STR_PAD_LEFT);

      FactureLivraison::create([
        "facture_id"       => $request->facture_id,
        "livraison_id"     => $request->livraison_id,
        "statut_livraison" => $request->statut,
        "adresse"          => $request->adresse,
        "date_livraison"   => $request->date_livraison,
        "montant"          => $request->price,
        "num_livraison"    => $reference,
        "num_bon"          => $num_bon,
      ]);
      $facture = Facture::find($request->facture_id);
      $facture->update([
        "net_payer"=>$facture->net_payer + $request->price,
        "reste"=>$facture->reste + $request->price,
        "etat_livraison"=>1,
      ]);
      toast("L'enregistrement de livraiosn effectuée");
      return redirect()->route('facture.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FactureLivraison  $FactureLivraison
     * @return \Illuminate\Http\Response
     */
    public function show(FactureLivraison $factureLivraison)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FactureLivraison  $FactureLivraison
     * @return \Illuminate\Http\Response
     */
    public function edit(FactureLivraison $factureLivraison)
    {
      $livraisons = DB::table("livraisons")->get();
      $all = [
        "livraisons"       => $livraisons,
        "factureLivraison" => $factureLivraison,
      ];
      return view("factureLivraisons.edit",$all);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FactureLivraison  $FactureLivraison
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FactureLivraison $factureLivraison)
    {
      $request->validate([
        "price"           => ["required",'numeric','min:0'],
        "adresse"        => ["required"],
        "status"         => ["required"],
        "date_livraison" => ['required'],
        "livraison_id"          => ['required',"exists:livraisons,id"],
      ]);
      $facture = Facture::find($factureLivraison->facture_id);
      $net_payer_avant = $facture->net_payer - $factureLivraison->montant;
      $reste_avant = $facture->reste - $factureLivraison->montant;
      $factureLivraison->update([
        "livraison_id"     => $request->livraison_id,
        "statut_livraison" => $request->status,
        "adresse"          => $request->adresse,
        "date_livraison"   => $request->date_livraison,
        "montant"          => $request->price,
      ]);
      $facture->update([
        "net_payer"=>$net_payer_avant + $request->price,
        "reste"=>$reste_avant + $request->price,
      ]);
      toast("La modification de livraiosn effectuée");
      return back();
    }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\FactureLivraison  $FactureLivraison
   * @return \Illuminate\Http\Response
   */
  public function annuler(Request $request, FactureLivraison $factureLivraison)
  {

    $factureLivraison->update([
      "statut_livraison" => "annuler",
    ]);

    toast("L'annulation de livraiosn effectuée","success");
    return back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\FactureLivraison  $FactureLivraison
   * @return \Illuminate\Http\Response
  */
  public function destroy(FactureLivraison $factureLivraison)
  {
    $factureLivraison->delete();
    return back();
  }

  public static function asLetters($number) {
    $convert = explode('.', $number);
    $num[17] = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit',
    'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize');

    $num[100] = array(20 => 'vingt', 30 => 'trente', 40 => 'quarante', 50 => 'cinquante',
    60 => 'soixante', 70 => 'soixante-dix', 80 => 'quatre-vingt', 90 => 'quatre-vingt-dix');

    if (isset($convert[1]) && $convert[1] != '') {
    return self::asLetters($convert[0]).' et '.self::asLetters($convert[1]);
    }
    if ($number < 0) return 'moins '.self::asLetters(-$number);
    if ($number < 17) {
    return $num[17][$number];
    }
    elseif ($number < 20) {
    return 'dix-'.self::asLetters($number-10);
    }
    elseif ($number < 100) {
    if ($number%10 == 0) {
    return $num[100][$number];
    }
    elseif (substr($number, -1) == 1) {
    if( ((int)($number/10)*10)<70 ){
    return self::asLetters((int)($number/10)*10).'-et-un';
    }
    elseif ($number == 71) {
    return 'soixante-et-onze';
    }
    elseif ($number == 81) {
    return 'quatre-vingt-un';
    }
    elseif ($number == 91) {
    return 'quatre-vingt-onze';
    }
    }
    elseif ($number < 70) {
    return self::asLetters($number-$number%10).'-'.self::asLetters($number%10);
    }
    elseif ($number < 80) {
    return self::asLetters(60).'-'.self::asLetters($number%20);
    }
    else {
    return self::asLetters(80).'-'.self::asLetters($number%20);
    }
    }
    elseif ($number == 100) {
    return 'cent';
    }
    elseif ($number < 200) {
    return self::asLetters(100).' '.self::asLetters($number%100);
    }
    elseif ($number < 1000) {
    return self::asLetters((int)($number/100)).' '.self::asLetters(100).($number%100 > 0 ? ' '.self::asLetters($number%100): '');
    }
    elseif ($number == 1000){
    return 'mille';
    }
    elseif ($number < 2000) {
    return self::asLetters(1000).' '.self::asLetters($number%1000).' ';
    }
    elseif ($number < 1000000) {
    return self::asLetters((int)($number/1000)).' '.self::asLetters(1000).($number%1000 > 0 ? ' '.self::asLetters($number%1000): '');
    }
    elseif ($number == 1000000) {
    return 'millions';
    }
    elseif ($number < 2000000) {
    return self::asLetters(1000000).' '.self::asLetters($number%1000000);
    }
    elseif ($number < 1000000000) {
    return self::asLetters((int)($number/1000000)).' '.self::asLetters(1000000).($number%1000000 > 0 ? ' '.self::asLetters($number%1000000): '');
    }
  }

  public function bonLivraison($id){
    $factureLivraison = FactureLivraison::find($id);
    $facture          = $factureLivraison->facture;
    $entreprise       = Entreprise::find($facture->entreprise_id);
    $client           = Client::find($facture->client_id);
    $letter_chiffre = $this->asLetters(($facture->ttc));
    $all = [
      "facture"          => $facture,
      "factureLivraison" => $factureLivraison,
      "entreprise"       => $entreprise,
      "client"           => $client,
      "letter_chiffre"           => $letter_chiffre,
    ];
    $pdf = Pdf::loadview('factureLivraisons.bon',$all);
    return $pdf->stream("bon livraison:".$factureLivraison->num_bon);
    // return $pdf->download('facture.pdf');
  }

}
