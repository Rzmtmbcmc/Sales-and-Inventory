<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    //
    public function showView():View|RedirectResponse{
        return view('owner.products');
    }
    /**
     * Handle the request to add a new product.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkstock($id){
        $product = Products::find($id);
        if($product::where('id',$id)->quantity == 0){
            $product->delete();
            return true;
        }
        return false;
    }
}
