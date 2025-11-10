<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modalidade; 
use App\Models\Plano;      

class HomeController extends Controller
{
    public function index()
    {
        $modalidades = Modalidade::orderBy('nome', 'asc')->get();
        
        return view('welcome', [
            'modalidades' => $modalidades
            // 'planos' => $planos 
        ]);
    }
}