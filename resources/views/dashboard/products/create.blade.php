<x-layouts.app :title="__('Products')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Add New Product</flux:heading>
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

    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        
        <flux:input label="Name" name="name" class="mb-3" value="{{ old('name') }}" required />
        
        <flux:textarea label="Description" name="description" class="mb-3" value="{{ old('description') }}" />
        
        <flux:input 
            label="Price" 
            name="price" 
            type="number" 
            step="0.01" 
            class="mb-3" 
            value="{{ old('price') }}" 
            required 
        />
        
        <flux:input 
            label="Stock Quantity" 
            name="stock_quantity" 
            type="number" 
            min="0" 
            class="mb-3" 
            value="{{ old('stock_quantity', 0) }}" 
            required 
        />
        
        <flux:input type="file" label="Image" name="image" class="mb-3" />
        
        <flux:separator />
        
        <div class="mt-4">
            <flux:button type="submit" variant="primary">Simpan</flux:button>
            <flux:link href="{{ route('products.index') }}" variant="ghost" class="ml-3">Kembali</flux:link>
        </div>
    </form>
</x-layouts.app>