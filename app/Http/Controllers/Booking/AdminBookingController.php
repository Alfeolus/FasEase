<?php

namespace App\Http\Controllers\Booking;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminBookingController extends Controller
{
    public function index(){
        $bookings = Booking::with(['user', 'item'])
            ->where('organization_id', auth()->user()->organization_id)
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('booking.booking-management-admin', compact('bookings'));
    }

    public function show_booking_history(){
        $bookings = Booking::with(['user', 'item'])
            ->where('organization_id', auth()->user()->organization_id)
            ->whereIn('status', ['approved', 'rejected'])
            ->latest()
            ->get();

        return view('booking.booking-history', compact('bookings'));
    }

    public function approve($id)
    {
        Booking::findOrFail($id)->update([
            'status' => 'approved',
            'reject_reason' => null
        ]);

        return back()->with('success', 'Booking approved');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reject_reason' => 'required|string|max:255'
        ]);

        Booking::findOrFail($id)->update([
            'status' => 'rejected',
            'reject_reason' => $request->reject_reason
        ]);

        return back()->with('success', 'Booking rejected');
    }

}
