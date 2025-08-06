<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    //
    public function addSales(Request $request){
        $request->validate([
            'CustomerName'=>'required',
            'ItemName'=>'required',
            'ItemPrice'=>'required',
            'ItemQuantity'=>'required',
            'TotalPrice'=>'required',
        ]);
    }
    public function viewSales(){
        return view('Sales.index');
    }
    public function deleteSales(Request $request){
        $request->validate([
            'CustomerName'=>'required',
        ]);
    }
    public function editSales(Request $request){
        $request->validate([
            'CustomerName'=>'required',
            'ItemName'=>'required',
            'ItemPrice'=>'required',
            'ItemQuantity'=>'required',
            'TotalPrice'=>'required',
        ]);
    }
}
