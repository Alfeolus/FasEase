@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All items</h5>
                        </div>
                        <a href="{{ route('org.item-management-create') }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New Item</a>
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Photo
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Slug
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Category
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Organization
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
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

                                    <td>
                                        <div>
                                            <img src="{{ asset($data->image) }}" class="avatar avatar-sm me-3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $data->name }}</p>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $data->slug }}</p>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $data->category->name }}</p>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $data->organization->name }}</p>
                                    </td>

                                    <td class="text-center">
                                        @if($data->is_active)
                                            <span class="badge badge-sm bg-gradient-success">Available</span>
                                        @else
                                            <span class="badge badge-sm bg-gradient-danger">Unavailable</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $data->created_at }}</span>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('org.item-management-edit', $data->slug) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Item">
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>
                                        <span>
                                            <a href="{{ route('org.item-management-destroy', $data->slug) }}"
                                            class="mx-3"
                                            data-bs-toggle="tooltip"
                                            title="Delete Item"
                                            onclick="event.preventDefault(); if(confirm('Delete this item?')) document.getElementById('delete-form-{{ $data->slug }}').submit();">
                                                <i class="fas fa-trash text-secondary"></i>
                                            </a>
                                            <form id="delete-form-{{ $data->slug }}" action="{{ route('org.item-management-destroy', $data->slug) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No items found
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
 
@endsection