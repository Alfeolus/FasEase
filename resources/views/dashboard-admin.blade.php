@extends('layouts.user_type.auth')

@section('content')
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Pending Request</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $pendingBookings }}
                  <span class="text-danger text-sm font-weight-bolder">Need Action</span>
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="fa fa-stopwatch text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Currently Borrowed</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $activeBookings }}
                  <span class="text-success text-sm font-weight-bolder">Items</span>
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="fa fa-star text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Assets</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $totalItems }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="fa fa-box text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Categories</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $totalCategories }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="fa fa-landmark text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  {{-- Recent users table --}}
  <div class="card mt-4">
      <div class="card-header">
          <h6>Pending Booking Requests</h6>
          <p class="text-sm mb-0">
            <i class="fa fa-check text-info" aria-hidden="true"></i>
            Waiting for your approval
          </p>
      </div>
      <div class="card-body table-responsive">
          <table class="table">
              <thead>
                  <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Item</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Range</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                  </tr>
              </thead>
              <tbody>
                  @forelse($recentRequests as $booking)
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">{{ $booking->user->name }}</h6>
                          <p class="text-xs text-secondary mb-0">{{ $booking->user->email }}</p>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="text-xs font-weight-bold">{{ $booking->item->name }}</span>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="text-xs font-weight-bold">
                        {{ date('d M', strtotime($booking->start_date)) }} - {{ date('d M', strtotime($booking->end_date)) }}
                      </span>
                    </td>
                    <td class="align-middle text-center">
                      {{-- Contoh Button Action (Sesuaikan route-nya) --}}
                      <a href="#" class="btn btn-link text-success text-gradient px-3 mb-0"><i class="fa fa-check"></i> Approve</a>
                      <a href="#" class="btn btn-link text-danger text-gradient px-3 mb-0"><i class="fa fa-times"></i> Reject</a>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4" class="text-center py-4">
                        <span class="text-sm text-secondary">No pending requests</span>
                    </td>
                  </tr>
                  @endforelse
              </tbody>
          </table>
      </div>
  </div>

  {{-- Chart --}}
  <div class="card z-index-2 my-4">
    <div class="card-header pb-0">
      <h6>Bookings Overview</h6> </div>
    <div class="card-body p-3">
      <div class="chart">
        <canvas id="chart-bars" class="chart-canvas" height="300"></canvas>
      </div>
    </div>
  </div>


@endsection
@push('dashboard')
<script>
window.onload = function () {
  var labels = @json($bookingChartLabels);
  var userData = @json($bookingChartData);

  var ctx = document.getElementById("chart-bars").getContext("2d");

  new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels,
      datasets: [{
        label: "New Users per Day",
        borderRadius: 4,
        backgroundColor: "#17c1e8",
        data: userData,
        maxBarThickness: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            color: "#fff"
          }
        },
        x: {
          ticks: {
            color: "#fff",
            maxRotation: 45,
            minRotation: 45
          }
        }
      }
    }
  });
};
</script>
@endpush