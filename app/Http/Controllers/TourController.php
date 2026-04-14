<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    /**
     * Display a listing of all tours.
     */
    public function index()
    {
        $tours = Tour::all();
        return view('tours.index', compact('tours'));
    }

    /**
     * Display specific tour details.
     */
    public function show($id)
    {
        $tour = Tour::findOrFail($id);
        return view('tours.show', compact('tour'));
    }
}
