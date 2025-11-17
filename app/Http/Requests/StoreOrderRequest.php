<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            // 'products' harus ada, harus berupa array, dan tidak boleh kosong
            'products' => 'required|array|min:1',
            
            // Validasi untuk setiap item DI DALAM array 'products'
            'products.*.product_id' => 'required|integer|exists:products,id', // <-- Cek 'product_id' ada di DB
            'products.*.quantity' => 'required|integer|min:1', // <-- Kuantitas minimal 1
        ];
    }
    public function messages(): array
    {
        return [
            'products.required' => 'Keranjang belanja tidak boleh kosong.',
            'products.*.product_id.required' => 'Setiap item harus memiliki product_id.',
            'products.*.product_id.exists' => 'Satu atau lebih produk tidak ditemukan di database.',
            'products.*.quantity.min' => 'Jumlah pembelian minimal 1 untuk setiap produk.',
        ];
    }
}
