@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        Create Color
                        <a href="{{ url('admin/colors') }}" class="btn btn-sm btn-primary float-end">Back</a>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/colors') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Color Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Color Code</label>
                        <input type="text" name="code" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <input type="checkbox" name="status" style="width:30px;height:30px"> Unchecked=Visible,Checked=Hidden
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary float-end">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
