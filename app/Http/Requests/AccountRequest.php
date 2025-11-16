<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
        // Ambil ID user yang sedang di-edit dari URL
        $userIdToIgnore = $this->route('id');

        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:1000', // <-- Lebih baik tambahkan max
            'phone_number' => 'required|string|max:20', // <-- Hapus 'numeric'

            // 2. Tambahkan validasi untuk field penting lainnya
            'email' => [
                'required',
                'string',
                'email',
                // Cek apakah email unik, TAPI abaikan (ignore) user yang sedang kita edit
                Rule::unique('users')->ignore($userIdToIgnore),
            ],
            // 'nullable' berarti password boleh dikosongkan (tidak di-update)
            // 'confirmed' berarti request harus menyertakan 'password_confirmation'
            'password' => 'nullable|string|min:8',
            
            // 'boolean' memastikan nilainya true/false atau 1/0
            'is_admin' => 'nullable|boolean',
        ];
    }
}
