@extends('layouts.admin')

@section('title','User List')

@section('content')

     <div class="row">
        <div class="col-md-12">
            @if(session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3>
                        Users
                        <a href="{{ url('admin/users/create') }}" class="btn btn-sm btn-primary float-end">Add User</a>
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->role_as == '0')
                                        <label class="badge bg-secondary">User</label>
                                    @elseif ($user->role_as == '1')
                                        <label class="badge bg-success">Admin</label>
                                    @else
                                        <label class="badge bg-danger">None</label>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('admin/users/'.$user->id.'/edit') }}" class="btn btn-primary">Edit</a>
                                    <a href="{{ url('admin/users/'.$user->id.'/delete') }}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete?')">Delete</a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No user</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                    <div>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
