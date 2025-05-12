<x-layouts.app :title="__('Products')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Update Product</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage data Products</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if(session()->has('successMessage'))
        <flux:badge color="lime" class="mb-3 w-full">{{session()->get('successMessage')}}</flux:badge>
    @elseif(session()->has('errorMessage'))
        <flux:badge color="red" class="mb-3 w-full">{{session()->get('errorMessage')}}</flux:badge>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="mb-3">
            <flux:badge color="red" class="w-full">Please correct the errors below</flux:badge>
            <ul class="mt-2 list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li class="text-red-600">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @method('patch')
        @csrf
        
        <flux:input label="Name" name="name" value="{{ $product->name }}" class="mb-3" required />
        
        <flux:textarea label="Description" name="description" class="mb-3">{{ $product->description }}</flux:textarea>
        
        <flux:input 
            label="Price" 
            name="price" 
            type="number" 
            step="0.01" 
            value="{{ $product->price }}" 
            class="mb-3" 
            required 
        />
        
        <flux:input 
            label="Stock Quantity" 
            name="stock_quantity" 
            type="number" 
            min="0" 
            value="{{ $product->stock_quantity }}" 
            class="mb-3" 
            required 
        />
        
        @if($product->image)
            <div class="mb-3">
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded">
            </div>
        @endif
        
        <flux:input type="file" label="Image" name="image" class="mb-3" />
        
        <flux:separator />
        
        <div class="mt-4">
            <flux:button type="submit" variant="primary">Update</flux:button>
            <flux:link href="{{ route('products.index') }}" variant="ghost" class="ml-3">Kembali</flux:link>
        </div>
    </form>
</x-layouts.app>