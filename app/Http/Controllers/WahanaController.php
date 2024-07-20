<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wahana;

class WahanaController extends Controller
{
    //
    public function wahanaDashboard()
    {
        $wahanas = Wahana::all();
        return view('dashboard')->with('wahanas', $wahanas);
    }
    public function show($id)
    {
        $wahana = Wahana::where('wahana_id', $id)->firstOrFail();

        // $wahana = Wahana::findOrFail($id);
        return view('wahana.detail', compact('wahana'));
    }
}
