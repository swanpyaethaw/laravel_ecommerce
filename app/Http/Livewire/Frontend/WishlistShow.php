<?php

namespace App\Http\Livewire\Frontend;

use App\Models\WishList;
use Livewire\Component;

class WishlistShow extends Component
{

    public function removeWishListItem($wishlistId){
         WishList::where('user_id',auth()->user()->id)->where('id',$wishlistId)->delete();
         $this->emit('wishlistAddedUpdated');
         $this->dispatchBrowserEvent('message', [
            'text' => 'Wishlist remove successfully',
            'type' => 'success',
            'status' =>200
        ]);

    }

    public function render()
    {
        $wishlist = WishList::where('user_id',auth()->user()->id)->get();
        return view('livewire.frontend.wishlist-show',[
            'wishlist' => $wishlist
        ]);
    }
}
