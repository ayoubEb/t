<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Group;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetDataController extends Controller
{
    public function GroupClient(Request $request){

        $group_remise  = Group::join("clients","groups.id","=","clients.group_id")

                        ->where("clients.id",$request->id)
                        ->first(["clients.id","groups.nom","remise"]);



        return $group_remise;

    }



    public function getProduit(Request $request){
        $reference = $request->ref;
        $data  = Produit::select("id","reference","prix_vente","designation")->where("reference",$reference)->first();
        return $data;
    }
 
    public function ClientYear(Request $request){
    $data = Client::select(DB::raw("COUNT(*) as count"))->whereYear('created_at',$request->year)->groupBy(DB::raw("Month(created_at)"))->pluck("count");
    $months = Client::select(DB::raw("Month(created_at) as month"))->whereYear('created_at',$request->year)->groupBy(DB::raw("Month(created_at)"))->pluck('month');
    $data_client = array(0,0,0,0,0,0,0,0,0,0,0,0);
    foreach($months as $index => $month){
        $data_client[$month-1] = $data[$index];
    }
    return response()->json($data);
    }
}
