<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Inventory extends Controller
{
    public function addInventory(Request $request){
        $request->validate([
            'ItemName'=>'required',
            'ItemType'=>'required',
            'ItemPrice'=>'required',
            'ItemQuantity'=>'required',
            'ItemDescription'=>'required',
        ]);
    }
    public function deleteInventory(Request $request){
        $request->validate([
            'ItemName'=>'required',
        ]);
    }
    public function editInventory(Request $request){
        $request->validate([
            'ItemName'=>'required',
            'ItemType'=>'required',
            'ItemPrice'=>'required',
            'ItemQuantity'=>'required',
            'ItemDescription'=>'required',
        ]);
    }
    public function viewInventory(){
        return view('Inventory.index');
    }
}
