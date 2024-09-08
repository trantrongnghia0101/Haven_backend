<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255', // Tên sản phẩm bắt buộc
            'price' => 'required|numeric|min:0', // Giá sản phẩm là số và >= 0
            'weight' => 'required|numeric|min:0', // Trọng lượng sản phẩm là số và >= 0
            'quantity' => 'required|integer|min:0', // Số lượng sản phẩm là số nguyên không âm
            'expiry' => 'nullable|date', // Ngày hết hạn (có thể rỗng nhưng phải là kiểu ngày hợp lệ)
            'preserve' => 'boolean', // Điều kiện bảo quản phải là boolean (true hoặc false)
            'description' => 'nullable|string', // Mô tả có thể rỗng
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Ảnh phải là file hình hợp lệ với dung lượng tối đa 2MB
            'category_id' => 'required|exists:categories,id', // ID danh mục bắt buộc, phải tồn tại trong bảng categories
            'brand_id' => 'nullable|exists:brands,id', // ID thương hiệu có thể rỗng, nếu có phải tồn tại trong bảng brands
            'manufacture' => 'required|string|max:255', // Ngày sản xuất là chuỗi bắt buộc
            'subtitle' => 'nullable|string|max:255', // Phụ đề có thể rỗng, tối đa 255 ký tự
            'sale' => 'integer', // Thông tin giảm giá phải là kiểu boolean
        ];
    }
}
