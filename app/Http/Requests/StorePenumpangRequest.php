<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenumpangRequest extends FormRequest
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
            'usia' => 'required|integer|min:1|max:120',
            'jenis_kelamin' => 'required|in:L,P',
            'tujuan' => 'required|string|max:255',
            'tanggal' => 'required|date|after_or_equal:today',
            'nopol' => 'required|string|max:20',
            'jenis_kendaraan' => 'required|string|max:100',
            'nomor_tiket' => 'required|string|max:50|unique:penumpang,nomor_tiket',
            'url_image_tiket' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'boolean',
        ];
    }

    /**
     * Get custom validation messages
     */
    public function messages(): array
    {
        return [
            'usia.required' => 'Usia wajib diisi',
            'usia.integer' => 'Usia harus berupa angka',
            'usia.min' => 'Usia minimal 1 tahun',
            'usia.max' => 'Usia maksimal 120 tahun',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'jenis_kelamin.in' => 'Jenis kelamin harus L atau P',
            'tujuan.required' => 'Tujuan wajib diisi',
            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.after_or_equal' => 'Tanggal tidak boleh kurang dari hari ini',
            'nopol.required' => 'Nomor polisi wajib diisi',
            'jenis_kendaraan.required' => 'Jenis kendaraan wajib diisi',
            'nomor_tiket.required' => 'Nomor tiket wajib diisi',
            'nomor_tiket.unique' => 'Nomor tiket sudah digunakan',
            'url_image_tiket.required' => 'Foto tiket wajib diupload',
            'url_image_tiket.image' => 'File harus berupa gambar',
            'url_image_tiket.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'url_image_tiket.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
}
