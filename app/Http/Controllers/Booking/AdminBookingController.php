<?php

namespace App\Http\Controllers\Booking;

use App\Models\Booking;
use App\Notifications\BookingStatusUpdatedNotification;
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
            ->whereIn('status', ['approved', 'rejected', 'pending'])
            ->latest()
            ->get();

        return view('booking.booking-history', compact('bookings'));
    }

    public function approve($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => 'approved',
            'reject_reason' => null
        ]);

        if($booking->user) {
            $booking->user->notify(new BookingStatusUpdatedNotification($booking));
        }

        return back()->with('success', 'Booking approved');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reject_reason' => 'required|string|max:255'
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => 'rejected',
            'reject_reason' => $request->reject_reason
        ]);

        if($booking->user) {
            $booking->user->notify(new BookingStatusUpdatedNotification($booking));
        }
        return back()->with('error', 'Booking rejected');
    }

}
