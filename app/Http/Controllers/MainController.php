<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class MainController extends Controller
{
    public function owner():View{
        return view('owner.index');
    }
    public function customer():View{
        return view('customer.index');
    }
    public function manager():View{
        return view('manager.index');
    }
}
