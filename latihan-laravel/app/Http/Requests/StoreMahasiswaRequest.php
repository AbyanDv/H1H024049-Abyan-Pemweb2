<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMahasiswaRequest extends FormRequest
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
        // Mendapatkan ID mahasiswa jika dalam konteks Update Request
        $mahasiswaId = $this->route('mahasiswa')?->id ?? $this->route('mahasiswa');

        return [
            'program_studi_id' => ['required', 'integer', 'exists:program_studis,id'],
            'nim'              => ['required', 'string', 'max:20', Rule::unique('mahasiswas', 'nim')->ignore($mahasiswaId)],
            'nama'             => ['required', 'string', 'max:100'],
            'email'            => ['required', 'email', 'max:100', Rule::unique('mahasiswas', 'email')->ignore($mahasiswaId)],
            'angkatan'         => ['required', 'integer', 'min:2000', 'max:2100'],
            'ipk'              => ['nullable', 'numeric', 'min:0', 'max:4'],
            'aktif'            => ['nullable', 'boolean'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'program_studi_id.required' => 'Program studi wajib dipilih.',
            'program_studi_id.exists'   => 'Program studi tidak ditemukan.',
            'nim.required'              => 'NIM wajib diisi.',
            'nim.unique'                => 'NIM tersebut sudah terdaftar.',
            'nama.required'             => 'Nama mahasiswa wajib diisi.',
            'email.required'            => 'Email wajib diisi.',
            'email.email'               => 'Format email tidak valid.',
            'email.unique'              => 'Email tersebut sudah digunakan.',
            'angkatan.required'         => 'Tahun angkatan wajib diisi.',
            'angkatan.min'              => 'Tahun angkatan tidak wajar.',
            'angkatan.max'              => 'Tahun angkatan melampaui batas.',
            'ipk.numeric'               => 'IPK harus berupa angka.',
            'ipk.min'                   => 'IPK minimal adalah 0.',
            'ipk.max'                   => 'IPK maksimal adalah 4.',
        ];
    }
}