@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        Create Category
                        <a href="{{ url('admin/category') }}" class="btn btn-sm btn-primary float-end">Back</a>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/category') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Name</label><br>
                                <input type="text" name="name" class="form-control">
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Slug</label><br>
                                <input type="text" name="slug" class="form-control">
                                @error('slug')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Description</label><br>
                                <textarea name="description"  class="form-control" rows="3"></textarea>
                                @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Image</label><br>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Status</label><br>
                                <input type="checkbox" name="status">
                            </div>
                            <div class="col-md-12 mb-3">
                                <h4>SEO tags</h4>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Meta Title</label><br>
                                <input type="text" name="meta_title" class="form-control">
                                @error('meta_title')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Meta Keyword</label><br>
                                <input type="text" name="meta_keyword" class="form-control">
                                @error('meta_keyword')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Meta Description</label><br>
                                <textarea name="meta_description"  class="form-control" rows="3"></textarea>
                                @error('meta_description')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-primary float-end">Save</button>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
