<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;


class UpdateProduct extends Component
{

 use WithFileUploads;

    #[validate('required|string|max:255|min:5')]
    public $name;
    #[validate('required|string|max:2000')]
    public $description;
    #[validate('required|string|max:255')]
    public $price;
    #[validate('nullable|image|max:1024')]
    public $image;
    #[validate('required')]
    public $category_id;

    public $photo;
    public $id;
    public $data = [];

    public function mount(Product $id)
    {
        $this->id = $id->id;
        $this->name = $id->name;
        $this->description = $id->description;
        $this->photo = $id->image; 
        $this->price = $id->price; 
        $this->category_id = $id->id;
    }
    
    public function update()
    {
    // dd($this->category_id); 
    $this->validate();

    $product = Product::findOrFail($this->category_id);
    
    $data = [];

    if ($this->name) {
        $data['name'] = $this->name;
    }

    if ($this->description) {
        $data['description'] = $this->description;
    }
    if ($this->category_id) {
        $data['category_id'] = $this->category_id;
    }
 
  if ($this->image) {
            if ($this->image instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $this->image->store('product', 'public');
            if($product->image){
            $path=public_path('storage/').$product->image;
            if(file_exists($path)){
                @unlink($path);
            }
        }
    }
}


    if (!empty($data)) {
        $product->update($data);
    }

    session()->flash('status', 'Category section successfully updated.');

    return redirect('/product');
}

    public function render()
    {
        $categories = Category::get();
        return view('livewire.admin.product.update-product',compact('categories'));
    }
}