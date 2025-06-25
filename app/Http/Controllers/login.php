<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class login extends Controller
{
    public function showForm():View{
        return View('index');
    }
}
