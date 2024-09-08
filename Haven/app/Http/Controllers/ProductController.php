<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          // $keyword = $request->get('q');
          $brands = new Brand();
          $categories = new category();
          return view('Product.home', [
              'product' => Product::all(),
              'categories' => $categories::orderBy('id', 'desc')->get(),
              'brands' => $brands::orderBy('id', 'desc')->get(),
          ]);
          // return view('store');
          // dd(Product::all());
          // return response()->json([
          //     // 'test' =>Product::orderBy('id','desc')->take(8)->get(),
          //     'product' =>  Product::all(),
          // ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = new Brand();
        $categories = new Category();
        return view('Product.store', [
            'categories' => $categories::orderBy('id', 'desc')->get(),
            'brands' => $brands::orderBy('id', 'desc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //Lưu vào trong public//
        // dd($request->all());
        $object = new Product();

        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time() . '.' . $extension; 
        // $fileName = $request->file('image')->getClientOriginalName();
        $object->fill($request->except('image'));
        $object->image = $filename;
        $object->save();
        $request->file('image')->move('imgs', $filename);

        // lưu trong storage//
        // $path =  $request->file('image')->store('/imgs');
       
        return redirect()->route('Product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $brands = new Brand();
        $categories = new Category();
        return view('Product.edit', [
            'product' => $product,
            'categories' => $categories::orderBy('id', 'desc')->get(),
            'brands' => $brands::orderBy('id', 'desc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $input = $request->all();
        if ($request->file('image') == null) {
            unset($input['image']);
        } else {
            $file_path = public_path('imgs/' . $product->image);
            if (file_exists($file_path)) {
                unlink($file_path); 
            // return back()->with('success', 'Ảnh đã được xóa thành công!');
            } 
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = time() . '.' . $extension; 
            $input['image']= $filename;

            $request->file('image')->move('imgs',  $filename);
        }
        $product->update($input);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $file_path = public_path('imgs/' . $product->image);
        if (file_exists($file_path)) {
            unlink($file_path); 
            // return back()->with('success', 'Ảnh đã được xóa thành công!');
        } 
        $product->delete();
        return redirect()->back();
    }
}
