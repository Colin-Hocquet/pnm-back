<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Item::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Item::create($request->all())){
            return response()->json([
                'success' => 'Item créé avec succès !'
            ],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return $item;
    }

    /**
     * Find items linked to an inventory.
     *If inventory_id == id attribute, return the label and the id of items
     * @param  \App\Models\Inventory  inventory id param
     * @return \Illuminate\Http\Response
     */
    public function findAllItemByInventory(String $id)
    {

        $items = DB::table('items')->where('inventory_id', $id)->get(["id","label"]);
        return $items;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        if($item->update($request->all())){
            return response()->json([
                'success' => 'Item modifié avec succès !'
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        if($item->delete()){
            return response()->json([
                'success' => 'Item supprimé avec succès !'
            ],200);
        }
    }
}
