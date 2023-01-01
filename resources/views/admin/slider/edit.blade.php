@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        Edit Slider
                        <a href="{{ url('admin/sliders') }}" class="btn btn-sm btn-primary float-end">Back</a>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/sliders/'.$slider->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" value="{{ $slider->title }}" class="form-control">
                        @error('title')
                            <i class="text-danger">{{ $message }}</i>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description"  rows="3" class="form-control">{{ $slider->description }}</textarea>
                        @error('description')
                        <i class="text-danger">{{ $message }}</i>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
                        <img src="{{ asset("$slider->image") }}" style="width:50px;height:50px">
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <input type="checkbox" name="status" style="width:30px;height:30px" {{ $slider->status == '1' ? 'checked' : '' }}> Unchecked=Visible,Checked=Hidden
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary float-end">Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
