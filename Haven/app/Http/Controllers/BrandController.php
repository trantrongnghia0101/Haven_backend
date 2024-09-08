<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = new Brand();
        return view('Brand.home',[
            'Brands' => Brand::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Brand.store');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $object = new Brand();
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time() . '.' . $extension; 
        $object->fill($request->except('image'));
        $object->image = $filename;
        $object->save();
        $request->file('image')->move('imgs', $filename);
        return redirect()->route('Brand.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('Brand.edit', [
            'brand' => $brand,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $input = $request->all();
        if ($request->file('image') == null) {
            unset($input['image']);
        } else {
            // xóa ảnh cũ
            $file_path = public_path('imgs/' . $brand->image);
            if (file_exists($file_path)) {
                unlink($file_path); 
            // return back()->with('success', 'Ảnh đã được xóa thành công!');
            } 
            // đổi tên file ảnh rồi mới thêm vào á đổi tên theo thời gian
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = time() . '.' . $extension; 
            $input['image'] = $filename;
            $request->file('image')->move('imgs',  $filename);
        }
        $brand->update($input);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        // lấy đường dẫn file ảnh trong thư mục public rồi sau đó unlink là xóa file ảnh 
        $file_path = public_path('imgs/' . $brand->image);
        if (file_exists($file_path)) {
            unlink($file_path); 
            // return back()->with('success', 'Ảnh đã được xóa thành công!');
        } 
      
        $brand->delete();
        return redirect()->back();
    }
}
