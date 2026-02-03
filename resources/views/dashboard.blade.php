@extends('layouts.user_type.auth')

@section('content')
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Users</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $totalUsers }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="fa fa-users text-lg opacity-10" aria-hidden="true"></i>
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
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Organizations</p>
                <h5 class="font-weight-bolder mb-0">
                  {{  $totalOrganizations }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
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
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Active Users Today</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $activeUserToday }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="fa fa-clock text-lg opacity-10" aria-hidden="true"></i>
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
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Blocked Users</p>
                <h5 class="font-weight-bolder mb-0">
                  {{ $blockedUsers }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="fa fa-ban text-lg opacity-10" aria-hidden="true"></i>
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
          <h6>Recent Users</h6>
      </div>
      <div class="card-body table-responsive">
          <table class="table">
              <thead>
                  <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Status</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($recentUsers as $user)
                      <tr>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->email }}</td>
                          <td>{{ ucfirst($user->role) }}</td>
                          <td>
                            @if($user->is_active)
                                <span class="badge badge-sm bg-gradient-success">Active</span>
                            @else
                                <span class="badge badge-sm bg-gradient-danger">Blocked</span>
                            @endif
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
  </div>

  {{-- Recent organizations table --}}
  <div class="card mt-4">
      <div class="card-header">
          <h6>Recent Organizations</h6>
      </div>
      <div class="card-body table-responsive">
          <table class="table">
              <thead>
                  <tr>
                      <th>Name</th>
                      <th>Members</th>
                      <th>Location</th>
                      <th>Status</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($recentOrganizations as $org)
                      <tr>
                          <td>{{ $org->name }}</td>
                          <td>{{ $org->users()->count() }}</td>
                          <td>{{ $org->location }}</td>
                          <td>
                            @if($org->is_active)
                                <span class="badge badge-sm bg-gradient-success">Active</span>
                            @else
                                <span class="badge badge-sm bg-gradient-danger">Blocked</span>
                            @endif
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
  </div>

  {{-- Chart --}}
  <div class="card z-index-2 my-4">
    <div class="card-header pb-0">
      <h6>Sales Overview</h6> </div>
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
  var labels = @json($userChartLabels);
  var userData = @json($userChartData);

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