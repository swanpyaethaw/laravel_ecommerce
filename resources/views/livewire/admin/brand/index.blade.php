<div>
    @include('livewire.admin.brand.modal_form')


        <div class="row">
            <div class="col-md-12">
                @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
                @endif
                <div class="card">
                    <div class="card-header d-flex align-items-baseline justify-content-between">
                        <h3>Brand</h3>
                            <div class="d-flex gap-2">
                                <input type="search" wire:model="search" class="form-control " style="width:230px" placeholder="search...">
                                <a href="" class="btn  btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addBrandModal">Add Brand</a>
                            </div>


                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($brands as $brand)
                                    <tr>
                                        <td>{{$brand->id}}</td>
                                        <td>{{$brand->name}}</td>
                                        <td>{{$brand->slug}}</td>
                                        <td>{{ $brand->category->name }}</td>
                                        <td>{{$brand->status == '1' ? 'hidden' : 'visible'}}</td>
                                        <td>
                                            <a href="" data-bs-toggle="modal" data-bs-target="#updateBrandModal" wire:click="editBrand({{$brand->id}})" class="btn btn-success">Edit</a>
                                            <a href="" data-bs-toggle="modal" data-bs-target="#deleteBrandModal" wire:click="deleteBrand({{$brand->id}})" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No Brand</td>
                                    </tr>
                                @endforelse



                            </tbody>
                        </table><br>
                        {{$brands->links()}}
                    </div>
                </div>
            </div>
        </div>

</div>

@push('script')
<script>
    window.addEventListener('close-modal', event => {
        $('#addBrandModal').modal('hide');
        $('#updateBrandModal').modal('hide');
        $('#deleteBrandModal').modal('hide');
    })
    </script>
@endpush
