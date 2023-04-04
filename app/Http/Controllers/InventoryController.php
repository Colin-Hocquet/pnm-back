<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inventory::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $variable = Inventory::create($request->all());
        return $variable->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        return $inventory;
    }


    /**
     * Find all inventories by user_id and default inventory.
     * @param  \App\Models\Inventory  inventory id param
     * @return \Illuminate\Http\Response
     */
    public function findAllInventoriesByUserId(String $id)
    {
        $inventory = DB::table('inventories')->where('user_id', $id)->orWhere('default',1)->get();
        return $inventory;
    }

    /**
     * Find last inventory linked to the user.
     * @param  \App\Models\Inventory  inventory id param
     * @return \Illuminate\Http\Response
     */
    public function findLastInventoryByUserID(String $id)
    {

        $inventory = DB::table('inventories')->where('user_id', $id)->get(["id","label"])->last();
        return $inventory;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        if($inventory->update($request->all())){
            return response()->json([
                'success' => 'Inventaire modifié avec succès !'
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        $attribute = DB::table('inventories')->where('id',$inventory->id)->where('default',0)->get();

        if($attribute->isEmpty()){
            return response()->json([
                'error' => 'Les pièces par défauts ne peuvent pas être supprimés !'
            ], 400);
        } else {
            $inventory->delete();
            return response()->json([
                'success' => 'Pièce supprimé avec succès !'
            ], 200);
        }
    }
}
