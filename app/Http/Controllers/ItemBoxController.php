<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\ItemBox;
use Illuminate\Http\Request;

class ItemBoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ItemBox::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(ItemBox::create($request->all())){
            return response()->json([
                'success' => 'ItemBox créé avec succès !'
            ],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $itemBox
     * @return \Illuminate\Http\Response
     */
    public function show(ItemBox $itemBox)
    {
        return $itemBox;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $itemBox
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemBox $itemBox)
    {
        if($itemBox->update($request->all())){
            return response()->json([
                'success' => 'ItemBox modifié avec succès !'
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $itemBox
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemBox $itemBox)
    {
        if($itemBox->delete()){
            return response()->json([
                'success' => 'ItemBox supprimé avec succès !'
            ],200);
        }
    }
}
