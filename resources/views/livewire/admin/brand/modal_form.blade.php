
<div wire:ignore.self class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Brand</h5>
        <button type="button" wire:click="close_modal()"  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form wire:submit.prevent="storeBrand">
            <div class="modal-body">
                <div class="mb-3">
                    <label>Category</label>
                    <select wire:model.defer="category_id" class="form-control">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label>Brand Name</label>
                    <input type="text" wire:model.defer="name" class="form-control">
                     @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label>Brand Slug</label>
                    <input type="text" wire:model.defer="slug" class="form-control">
                    @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label>Status</label><br>
                    <input type="checkbox" wire:model.defer="status"> Checked = "Hidden",Uncheck = "Visible"
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click="close_modal()" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Brand</button>
            </div>
        </form>

    </div>
    </div>
</div>

<div wire:ignore.self class="modal fade" id="updateBrandModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Brand</h5>
        <button type="button" wire:click="close_modal()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div wire:loading class="p-2">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>Loading...
        </div>
        <div wire:loading.remove>
            <form wire:submit.prevent="updateBrand">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Category</label>
                        <select wire:model.defer="category_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Brand Name</label>
                        <input type="text" wire:model.defer="name" class="form-control">
                         @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Brand Slug</label>
                        <input type="text" wire:model.defer="slug" class="form-control">
                        @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Status</label><br>
                        <input type="checkbox" wire:model.defer="status"> Checked = "Hidden",Uncheck = "Visible"
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="close_modal()" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Brand</button>
                </div>
            </form>
        </div>



    </div>
    </div>
</div>

<div wire:ignore.self class="modal fade" id="deleteBrandModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Brand</h5>
        <button type="button" wire:click="close_modal()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>


        <form wire:submit.prevent="destroyBrand">
            <div class="modal-body">
                <h4>Are you sure want to delete?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click="close_modal()" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Yes.Delete</button>
            </div>
        </form>

    </div>
    </div>
</div>
