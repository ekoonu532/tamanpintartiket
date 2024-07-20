<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function eventMendatang()
    {
        $events = Event::where('waktu_mulai', '>', now())->orderBy('waktu_mulai')->paginate(10);
        return view('dashboard', compact('events'));
    }

    // Tambahan method lainnya sesuai kebutuhan seperti create, store, edit, update, delete, dll.
}
