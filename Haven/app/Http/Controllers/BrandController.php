<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
        $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath(), [
            'public_id' => $filename
        ])->getSecurePath();
       
        $object->fill($request->except('image'));
        $object->image = $uploadedFileUrl;
        $object->save();
        
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
            /// cập nhật ảnh thì xóa file ảnh cũ trên cloud
            $parsedUrl = parse_url($brand->image, PHP_URL_PATH);
                // Loại bỏ phần '/image/upload/' và các thư mục khác
            $pathParts = explode('/', $parsedUrl);
                // Lấy phần cuối cùng là public_id (bao gồm cả extension)
            $fileWithExtension = end($pathParts);
                // Loại bỏ phần extension (đuôi file .jpg, .png, ...)
            $publicId = pathinfo($fileWithExtension, PATHINFO_FILENAME);
            Cloudinary::destroy($publicId);

            // đổi tên file ảnh rồi mới thêm vào á đổi tên theo thời gian
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = time() . '.' . $extension; 
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath(), [
                'public_id' => $filename
            ])->getSecurePath();
            $input['image'] = $uploadedFileUrl;
            
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
        $parsedUrl = parse_url($brand->image, PHP_URL_PATH);
        // Loại bỏ phần '/image/upload/' và các thư mục khác
        $pathParts = explode('/', $parsedUrl);
        // Lấy phần cuối cùng là public_id (bao gồm cả extension)
        $fileWithExtension = end($pathParts);
        // Loại bỏ phần extension (đuôi file .jpg, .png, ...)
        $publicId = pathinfo($fileWithExtension, PATHINFO_FILENAME);
        Cloudinary::destroy($publicId);

        $brand->delete();
        return redirect()->back();
    }
}
