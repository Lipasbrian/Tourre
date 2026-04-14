<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Store a new booking.
     * Core Logic: Check available slots, reduce slots after booking
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email',
            'number_of_people' => 'required|integer|min:1|max:20',
        ]);

        // Get the tour and lock for atomicity
        $tour = Tour::lockForUpdate()->find($validated['tour_id']);

        // Check if slots are available
        if ($tour->available_slots < $validated['number_of_people']) {
            return redirect()->back()->with('error', 
                'Sorry! Only ' . $tour->available_slots . ' slots available for this tour.');
        }

        // Create the booking
        $booking = Booking::create([
            'tour_id' => $validated['tour_id'],
            'user_name' => $validated['user_name'],
            'user_email' => $validated['user_email'],
            'number_of_people' => $validated['number_of_people'],
        ]);

        // Reduce available slots
        $tour->available_slots -= $validated['number_of_people'];
        $tour->save();

        return redirect()->back()->with('success', 
            'Booking successful! ' . $validated['number_of_people'] . ' slot(s) booked for ' . $tour->name);
    }

    /**
     * Show booking confirmation
     */
    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);
        return view('bookings.confirm', compact('booking'));
    }
}
