<?php

namespace App\Http\Controllers;
use App\Models\Box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Box::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Box::create($request->all())) {
            return response()->json([
                'success' => 'Boîte créé avec succès !',
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function show(Box $box)
    {
        return $box;
    }

    /**
     * Find last box linked to a user.
     *If user_id == id attribute, return the last id of the box
     * @param  \App\Models\Inventory  inventory id param
     * @return \Illuminate\Http\Response
     */
    public function findLastBoxByUserID(String $id)
    {

        $box = DB::table('boxes')->where('user_id', $id)->get(["id"])->last();
        return $box;
    }

    /**
     * Find last box linked to a user.
     *If user_id == id attribute, return the last id of the box
     * @param  \App\Models\Inventory  inventory id param
     * @return \Illuminate\Http\Response
     */
    public function findAllBoxByUserID(String $id)
    {

        // $box = DB::table('boxes')->where('user_id', $id)->get();
        $box = DB::table('boxes')->where('user_id', $id)->get();
        // $box->push( DB::table('item_box')->where('box_id', 1)->get());

        return $box;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $itemBox
     * @return \Illuminate\Http\Response
     */
    public function showItemByBox(String $id)
    {
        $itemBox = DB::table('boxes')
             ->join('item_box', 'boxes.id', '=', 'item_box.box_id')
             ->join('items', 'items.id', '=', 'item_box.item_id')
             ->select( "boxes.label as boxName", "items.label as itemName", "item_box.quantity")
             ->where('item_box.box_id', $id)
             ->get();
        return $itemBox;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Box $box)
    {
        if ($box->update($request->all())) {
            return response()->json([
                'success' => 'Boîte modifié avec succès !',
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function destroy(Box $box)
    {
        if ($box->delete()) {
            return response()->json([
                'success' => 'Boîte supprimé avec succès !',
            ], 200);
        }
    }
}
