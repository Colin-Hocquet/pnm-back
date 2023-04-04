<?php

namespace App\Http\Controllers;

use App\Models\Item;
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $variable = Item::create($request->all());

        return $variable->id;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return $item;
    }

    /**
     * Find items linked to an inventory.
     *If inventory_id == id attribute, return the label and the id of items
     * @param \App\Models\Inventory  inventory id param
     * @return \Illuminate\Http\Response
     */
    public function findAllItemByInventory(string $id)
    {

        $items = DB::table('items')->where('inventory_id', $id)->get(["id", "label", "quantity","default"]);
        return $items;
    }

    /**
     * Get last item created by inventory
     * @param \App\Models\Inventory  inventory id param
     * @return \Illuminate\Http\Response
     */
    public function findLastItemByInventory(string $inventoryId)
    {
        $item = DB::table('items')->where("inventory_id",$inventoryId)->get(["id","label","quantity"])->last();
        return $item;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        if ($item->update($request->all())) {
            return response()->json([
                'success' => 'Item modifié avec succès !'
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $attribute = DB::table('items')->where('id',$item->id)->where('default',0)->get();

        if($attribute->isEmpty()){
            return response()->json([
                'error' => 'Les items par défauts ne peuvent pas être supprimés !'
            ], 400);
        } else {
            $item->delete();
            return response()->json([
                'success' => 'Item supprimé avec succès !'
            ], 200);
        }
    }
}
