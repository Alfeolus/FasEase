@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">

                    <div class="card-header pb-0">
                        <h6>Booking Requests</h6>
                        <p class="text-sm text-secondary mb-0">
                            Pending booking requests waiting for approval
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
                                            Action
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
                                                    Qty: {{ $booking->quantity }}
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
                                                <span class="badge badge-sm bg-gradient-warning">
                                                    Pending
                                                </span>
                                            </td>

                                            {{-- Action --}}
                                            <td class="align-middle text-center">
                                                <form method="POST"
                                                      action="{{ url('/organization/booking/' . $booking->id . '/approve') }}"
                                                      class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-success btn-sm mb-0">
                                                        Approve
                                                    </button>
                                                </form>

                                                <button class="btn btn-danger btn-sm mb-0"
                                                        onclick="showRejectModal({{ $booking->id }})">
                                                    Reject
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-secondary">
                                                No pending booking requests
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

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" id="rejectForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Reject Booking</h6>
                </div>

                <div class="modal-body">
                    <label class="form-label">Reject Reason</label>
                    <textarea name="reject_reason"
                              class="form-control"
                              rows="3"
                              required></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-danger">
                        Reject
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('js')
<script>
    function showRejectModal(id) {
        const form = document.getElementById('rejectForm');
        form.action = `/organization/booking/${id}/reject`;
        new bootstrap.Modal(document.getElementById('rejectModal')).show();
    }
</script>
@endpush
