@extends('layouts.app')

@section('title','Thank You for Shopping')

@section('content')

    <div class="py pyt-md-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{session('message')}}
                        </div>
                    @endif
                    <h2>Your Logo</h2>
                    <h4>Thank You for Shopping with Funda Ecommerce</h4>
                    <a href="{{url('collections')}}" class="btn btn-primary">Shop now</a>
                </div>
            </div>
        </div>
    </div>

@endsection

