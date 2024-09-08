<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Http\Requests\StorecategoryRequest;
use App\Http\Requests\UpdatecategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = new Category();
        return view('Category.home',[
            'categories' => Category::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Category.store');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorecategoryRequest $request)
    {
        $object = new Category();
        // thêm dữ liệu vào từng cột tương ứng một cách nhanh chóng nhưng điều kiện tên input phải giống tên cột 
        $object->fill($request->all());
        $object->save();
        return redirect()->route('Category.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(category $category)
    {
        return view('Category.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecategoryRequest $request, category $category)
    {
        $category->update($request->all());
        return redirect()->route('Category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(category $category)
    {
        $category->delete();
      return redirect()->back();
    }
}
