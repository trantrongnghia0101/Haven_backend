<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\category;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
        
        $product = new Product();
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time() . '.' . $extension; 
        $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath(), [
            'public_id' => $filename
        ])->getSecurePath();
        $product->fill($request->except('image'));
        $product->image = $uploadedFileUrl;
        $product->save();
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
            $parsedUrl = parse_url($product->image, PHP_URL_PATH);
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
        $product->update($input);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $parsedUrl = parse_url($product->image, PHP_URL_PATH);
        // Loại bỏ phần '/image/upload/' và các thư mục khác
        $pathParts = explode('/', $parsedUrl);
        // Lấy phần cuối cùng là public_id (bao gồm cả extension)
        $fileWithExtension = end($pathParts);
        // Loại bỏ phần extension (đuôi file .jpg, .png, ...)
        $publicId = pathinfo($fileWithExtension, PATHINFO_FILENAME);
        Cloudinary::destroy($publicId);

        $product->delete();
        return redirect()->back();
    }
}
