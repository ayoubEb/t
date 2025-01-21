<?php

namespace App\Http\Controllers;

use App\Models\ProduitFiche;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduitFicheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if($request->hasFile("file")){
        $destination_path = 'public/files/produits/';
        $image_produit    = $request->file("file");
        $filename         = $image_produit->getClientOriginalName();
        $file_ex           = DB::table("produit_fiches")->where("title",$filename)->exists();
        $c                = DB::table("produit_fiches")->where("title",$filename)->count();
        $resu             = $filename;
        if($file_ex == true)
        {
          $resu = $filename.'( ' . $c + 1 . ')';
          $request->file("file")->storeAs($destination_path,$filename .'( ' . $c + 1 . ')');
        }
        else
        {
          $resu = $filename;
          $request->file("file")->storeAs($destination_path,$filename);

        }
      }


      ProduitFiche::create([
        "produit_id"=>$request->produit,
        "title"=>$resu ?? '',
      ]);
      return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProduitFiche  $produitFiche
     * @return \Illuminate\Http\Response
     */
    public function show(ProduitFiche $produitFiche)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProduitFiche  $produitFiche
     * @return \Illuminate\Http\Response
     */
    public function edit(ProduitFiche $produitFiche)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProduitFiche  $produitFiche
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProduitFiche $produitFiche)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProduitFiche  $produitFiche
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProduitFiche $produitFiche)
    {
        //
    }
}
