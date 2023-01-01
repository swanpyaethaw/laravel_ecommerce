@extends('layouts.admin')

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
                        Colors
                        <a href="{{ url('admin/colors/create') }}" class="btn btn-sm btn-primary float-end">Add Color</a>
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Color Name</th>
                                <th>Color Status</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($colors as $color)
                            <tr>
                                <td>{{ $color->id }}</td>
                                <td>{{ $color->name }}</td>
                                <td>{{ $color->code }}</td>
                                <td>{{ $color->status == '1' ? 'hidden' : 'visible' }}</td>
                                <td>
                                    <a href="{{ url('admin/colors/'.$color->id.'/edit') }}" class="btn btn-primary">Edit</a>
                                    <a href="{{ url('admin/colors/'.$color->id.'/delete') }}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete?')">Delete</a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No Color</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

