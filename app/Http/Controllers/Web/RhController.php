<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RhController extends Controller
{
    public function index()
    {
        // Aqui você pode retornar uma view do RH Dashboard
        return view('dashboard.rh');
    }
}
