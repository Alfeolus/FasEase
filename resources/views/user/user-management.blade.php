@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Users</h5>
                        </div>
                        <a href="{{ route('user-management-create') }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New User</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Phone
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Login URL
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        role
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Creation Date
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($datas as $data)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $data->id }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $data->name }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $data->email }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $data->phone }}</p>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <span class="text-xs text-secondary text-truncate" style="max-width:140px">
                                                {{ route('organization.login.link', $data->login_token) }}
                                            </span>

                                            <i class="fas fa-copy text-info cursor-pointer"
                                            title="Copy login URL"
                                            onclick="copyToClipboard('{{ route('organization.login.link', $data->login_token) }}')">
                                            </i>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $data->role }}</p>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $data->created_at }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('user-management-edit', $data->id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit user">
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>
                                        <span>
                                            <a href="{{ route('user-management-destroy', $data->id) }}"
                                            class="mx-3"
                                            data-bs-toggle="tooltip"
                                            title="Delete User"
                                            onclick="event.preventDefault(); if(confirm('Delete this user?')) document.getElementById('delete-form-{{ $data->id }}').submit();">
                                                <i class="fas fa-trash text-secondary"></i>
                                            </a>
                                            <form id="delete-form-{{ $data->id }}" action="{{ route('user-management-destroy', $data->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No users found
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

@push('js')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Login URL copied to clipboard!');
    }).catch(err => {
        console.error('Failed to copy:', err);
    });
}
</script>
@endpush


@endsection