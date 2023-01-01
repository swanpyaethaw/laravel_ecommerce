<?php

namespace App\Http\Livewire\Admin\Brand;

use App\Models\Brand;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name,$slug,$status,$brand_id,$category_id;
    public $search='';

    protected function rules()
    {
        return [
            'name' => 'required|string',
            'slug' => 'required|string',
            'status' => 'nullable',
            'category_id' => 'required|integer'
        ];
    }



    public function storeBrand(){

        $validatedData = $this->validate();

        Brand::create([
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
            'status' => $validatedData['status'] == true ? '1' : '0',
            'category_id' => $validatedData['category_id']
        ]);
        session()->flash('message','Brand Created Successfully');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editBrand(int $brand_id){
        $this->brand_id = $brand_id;
        $brand = Brand::find($brand_id);
        $this->name = $brand->name;
        $this->slug =  $brand->slug;
        $this->status = $brand->status;

    }

    public function updateBrand(){
        $validatedData = $this->validate();

        Brand::find($this->brand_id)->update([
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
            'status' => $validatedData['status'] == true ? '1' : '0',
            'category_id' => $validatedData['category_id']
        ]);
        session()->flash('message','Brand Updated Successfully');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');

    }

    public function deleteBrand(int $brand_id){
        $this->brand_id = $brand_id;
    }

    public function destroyBrand(){
        Brand::find($this->brand_id)->delete();
        session()->flash('message','Brand Deleted Successfully');
        $this->dispatchBrowserEvent('close-modal');

    }

    public function resetInput(){

        $this->name = '';
        $this->slug = '';
        $this->status = '';
        $this->category_id = '';


    }

    public function close_modal(){
        $this->resetInput();
        $this->resetErrorBag();

    }

    public function render()
    {
        $brands = Brand::where('name','like','%'.$this->search.'%')->orderBy('id','desc')->paginate(10);
        $categories = Category::where('status','0')->get();
        return view('livewire.admin.brand.index',['brands'=>$brands,'categories'=>$categories])
                ->extends('layouts.admin')
                ->section('content');
    }
}
