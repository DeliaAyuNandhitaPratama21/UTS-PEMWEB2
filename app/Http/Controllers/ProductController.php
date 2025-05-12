<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%')
                      ->orWhere('description', 'like', '%' . $request->q . '%');
            })
            ->paginate(10);

        return view('dashboard.products.index', [
            'products' => $products,
            'q' => $request->q
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'errors' => $validator->errors(),
                'errorMessage' => 'Validasi Error, Silahkan lengkapi data terlebih dahulu'
            ]);
        }

        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock_quantity = $request->stock_quantity;
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('uploads/products', $imageName, 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('products.index')->with([
            'successMessage' => 'Data Berhasil Disimpan'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return redirect()->route('products.index')->with([
                'errorMessage' => 'Product tidak ditemukan'
            ]);
        }
        
        return view('dashboard.products.show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return redirect()->route('products.index')->with([
                'errorMessage' => 'Product tidak ditemukan'
            ]);
        }

        return view('dashboard.products.edit', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'errors' => $validator->errors(),
                'errorMessage' => 'Validasi Error, Silahkan lengkapi data terlebih dahulu'
            ]);
        }

        $product = Product::find($id);
        
        if (!$product) {
            return redirect()->route('products.index')->with([
                'errorMessage' => 'Product tidak ditemukan'
            ]);
        }
        
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock_quantity = $request->stock_quantity;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('uploads/products', $imageName, 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('products.index')->with([
            'successMessage' => 'Data Berhasil Diperbarui'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return redirect()->route('products.index')->with([
                'errorMessage' => 'Product tidak ditemukan'
            ]);
        }

        $product->delete();

        return redirect()->route('products.index')->with([
            'successMessage' => 'Data Berhasil Dihapus'
        ]);
    }
}


