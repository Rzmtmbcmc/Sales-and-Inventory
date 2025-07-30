<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class InventoryController extends Controller
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
        $populate = Inventory::all();
        return view('owner.inventory', ['populate' => $populate]);
    }
}
