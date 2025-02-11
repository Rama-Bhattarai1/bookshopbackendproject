<div class="flex flex-col md:flex-row">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between">
            <p>{{ __('Book shop') }}</p>
            <p class="capitalize">{{ isset($product) ? 'Edit Product' : 'Create Product' }}</p>
        </h2>
    </x-slot>

    <!-- Sidebar -->
    <div class="bg-blue-900  shadow-lg h-screen w-64 sticky top-0 hidden sm:block">
        <div class="p-6">
            <a class="text-white text-2xl font-semibold" href="#">Book shop</a>
        </div>
        {{-- include leftside navbar --}}
        @includeIf('layout.admin.sidenavbar')
    </div>

    <div class="flex-1">
        <!-- Form Section -->
        <section class="container mx-auto px-4 py-12">
            <div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                    {{ isset($product) ? 'Edit Product Entry' : 'Create Product Entry' }}
                </h2>

                @if (session()->has('status'))
                    <div class="flex justify-center p-4 bg-green-800 w-full rounded-xl shadow-md">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="flex justify-center p-4 bg-red-600 w-full rounded-xl shadow-md">
                        {{ session('error') }}
                    </div>
                @endif

                <form wire:submit.prevent="update" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror"
                            id="name" wire:model.live="name" name="name" type="text">
                        @error('name')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                        <textarea
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror"
                            id="description" wire:model.live="description" name="description" rows="4"></textarea>
                        @error('description')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Price</label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('price') border-red-500 @enderror"
                            id="price" wire:model.live="price" name="price" type="text">
                        @error('price')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Image</label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('image') border-red-500 @enderror"
                            id="image" wire:model.live="image" type="file" name="image">
                        @if ($image)
                            <div class="mt-4">
                                <img class="w-20 border rounded-full" src="{{ $image->temporaryUrl() }}">
                            </div>
                        @endif
                        @if ($photo && !$image)
                            <div class="mt-4">
                                <img class="w-20 h-20 border rounded-full" src="{{ asset('storage/' . $photo) }}"
                                    alt="Selected Image">
                            </div>
                        @endif

                        @error('image')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>


                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="image">pdf file</label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('image') border-red-500 @enderror"
                            id="pdf" wire:model="pdf" type="file" name="pdf">
                  
                           
                       
                        @error('pdf')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="category_id">Category</label>
                        <select
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('category_id') border-red-500 @enderror"
                            id="category_id" wire:model.live="category_id" name="category_id">
                            <option>Select a Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700"
                            type="submit">Update Product</button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Footer Section -->
        @includeIf('layout.admin.footer')
    </div>
</div>
