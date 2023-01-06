@extends('layouts.app')

@section('title','User Profile')

@section('content')
    <div class="py-5">
        <div class="container">
            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            @if ($errors->any())
                <ul class="bg-warning">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <h4>User Profile
                        <a href="{{ url('change-password') }}" class="btn btn-warning float-end">Change Password ?</a>
                    </h4>
                    <div class="underline mb-3"></div>
                </div>

                <div class="col-md-10">
                    <div class="card shadow">
                        <div class="card-header bg-primary">
                            <h4 class="mb-0 text-white">User Details</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('profile') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>UserName</label>
                                            <input type="text" name="username" value="{{ Auth::user()->name }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Email Address</label>
                                            <input type="text" readonly value="{{ Auth::user()->email }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Phone Number</label>
                                            <input type="text" name="phone" value="{{ Auth::user()->userDetail->phone ?? '' }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Pin/Zip Code</label>
                                            <input type="text" name="pin_code" value="{{ Auth::user()->userDetail->pin_code ?? '' }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label>Address</label>
                                            <textarea name="address"  rows="3" class="form-control">{{ Auth::user()->userDetail->address ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Save Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
