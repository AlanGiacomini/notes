<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index($value)
    {
        /*OUTRA FORMA DE PASSAR PARÂMETRO PARA VIEW
        return view('main')->with)('value', $value);
        obs: aí teria que fazer uma linha dessa para cada valor
        */

        return view('main', [
            'value' => $value
        ]);
        
    }
    public function page2($value)
    {
        return view('page2', [
            'value' => $value
        ]);

    }
    public function page3($value)
    {
        return view('page3', [
            'value' => $value
        ]);

    }
}
