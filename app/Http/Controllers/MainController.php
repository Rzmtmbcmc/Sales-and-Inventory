<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class MainController extends Controller
{
    public function owner():View|RedirectResponse{
        if(!$this->AuthenticateUser()){
            return redirect()->route('Login')->with('status','Login to access Owner');
        }
        return view('owner.index');
    }
    public function customer():View|RedirectResponse{
        if(!$this->AuthenticateUser()){
            return redirect()->route('Login')->with('status','Login to access Customer');
        }
        return view('customer.index');
    }
    public function manager():View|RedirectResponse{
        if(!$this->AuthenticateUser()){
            return redirect()->route('Login')->with('status','Login to access Manager');
        }
        return view('manager.index');
    }

    public function AuthenticateUser():bool{
        $result = Auth::check();
        return $result;
    }
}
