@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">

                    <div class="card-header pb-0">
                        <h6>Booking History</h6>
                        <p class="text-sm text-secondary mb-0">
                            Approved & rejected booking records
                        </p>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">

                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Borrower
                                        </th>

                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Item
                                        </th>

                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Date & Time
                                        </th>

                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>

                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Notes
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($bookings as $booking)
                                        <tr>
                                            {{-- Borrower --}}
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">
                                                            {{ $booking->user->name }}
                                                        </h6>
                                                        <p class="text-xs text-secondary mb-0">
                                                            {{ $booking->user->email }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Item --}}
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $booking->item->name }}
                                                </p>
                                                <p class="text-xs text-secondary mb-0">
                                                    Qty: 1
                                                </p>
                                            </td>

                                            {{-- Date & Time --}}
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs mb-0">
                                                    {{ $booking->booking_date }}
                                                </p>
                                                <p class="text-xs text-secondary mb-0">
                                                    {{ $booking->start_time }} - {{ $booking->end_time }}
                                                </p>
                                            </td>

                                            {{-- Status --}}
                                            <td class="align-middle text-center">
                                                @if ($booking->status === 'approved')
                                                    <span class="badge badge-sm bg-info">
                                                        Approved
                                                    </span>
                                                @elseif ($booking->status === 'pending')
                                                    <span class="badge badge-sm bg-secondary">
                                                        Pending
                                                    </span>
                                                @elseif ($booking->status === 'canceled')
                                                    <span class="badge badge-sm bg-warning">
                                                        Canceled
                                                    </span>
                                                @elseif ($booking->status === 'completed')
                                                    <span class="badge badge-sm bg-success">
                                                        Completed
                                                    </span>
                                                @else
                                                    <span class="badge badge-sm bg-danger">
                                                        Rejected
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- Notes --}}
                                            <td class="align-middle text-center text-sm">
                                                @if ($booking->status === 'rejected')
                                                    <span class="text-body text-md">
                                                        {{ $booking->reject_reason }}
                                                    </span>
                                                @elseif($booking->status === 'canceled')
                                                    <span class="text-body text-md">
                                                        {{ $booking->cancel_reason }}
                                                    </span>
                                                @else
                                                    <span class="text-secondary text-xs">
                                                        —
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-secondary">
                                                No booking history available
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

@endsection
