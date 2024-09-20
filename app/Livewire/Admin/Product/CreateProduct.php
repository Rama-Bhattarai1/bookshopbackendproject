<?php

namespace App\Livewire\Admin\Product;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;

class CreateProduct extends Component
{
use WithFileUploads;
    #[validate('required|string|alpha|max:255|min:4')]
    public $name;
    #[validate('required|string|max:2000')]
    public $description;
    #[validate('required|numeric|min:100|max:100000')]
    public $price;
    #[validate('required|image|mimes:png,jpg,jpeg,jfif')]
    public $image;
    #[validate('required|file|mimes:pdf')]
    public $pdf;
    #[validate('required|numeric')]
    public $stock;
    #[validate('required')]
    public $category_id;

    public function render()
    {
        $categories = Category::get();
        return view('livewire.admin.product.create-product', compact('categories'));
    }

    public function save()
    {
        // Validate the input
        $validatedData = $this->validate();
        // dd($this->pdf);

        if ($this->image && $this->pdf) {
            // Store the image and get the path
            $validatedData['image'] = $this->image->store('products', 'public');
            // dd($validatedData['image']); // Check if image path is correct
    
            // Store the pdf and get the path
            $validatedData['pdf'] = $this->pdf->store('products', 'public');
            // dd($validatedData['pdf']);  // Check if PDF path is correct
        } else {
            throw ValidationException::withMessages([
                'image' => 'Image is required.',
                'pdf' => 'PDF is required.',
            ]);
        }
    
        // Save the product data
        Product::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'image' => $validatedData['image'],
            'pdf' => $validatedData['pdf'],
            'stock' => $validatedData['stock'],
            'category_id' => $validatedData['category_id']
        ]);

        session()->flash('status', 'Product successfully created.');

        // Redirect or reset form
        $this->reset();
    }
}