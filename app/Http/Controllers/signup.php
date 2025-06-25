<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class signup extends Controller
{
    public function showForm():View{
        return View('signup');
    }
}
