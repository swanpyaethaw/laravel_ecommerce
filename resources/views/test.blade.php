@extends('layouts.app')
@section('content')
<div class="rating-css">
                            <div class="star-icon">
                                <input type="radio" value="1"  wire:model="product_rating" id="rating1">
                                <label for="rating1" class="fa fa-star"></label>
                                <input type="radio" value="2" wire:model.defer="product_rating" id="rating2">
                                <label for="rating2" class="fa fa-star"></label>
                                <input type="radio" value="3" wire:model.defer="product_rating" id="rating3">
                                <label for="rating3" class="fa fa-star"></label>
                                <input type="radio" value="4" wire:model.defer="product_rating" id="rating4">
                                <label for="rating4" class="fa fa-star"></label>
                                <input type="radio" value="5" wire:model.defer="product_rating" id="rating5">
                                <label for="rating5" class="fa fa-star"></label>
                            </div>
                                @error('product_rating')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                        </div>
                        @endsection
