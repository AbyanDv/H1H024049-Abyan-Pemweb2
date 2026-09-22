<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMahasiswaRequest extends FormRequest
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
        // Penanganan fleksibel baik berupa Model Binding maupun ID angka biasa
        $mahasiswa = $this->route('mahasiswa');
        $id = is_object($mahasiswa) ? $mahasiswa->id : $mahasiswa;

        return [
            'program_studi_id' => ['sometimes', 'integer', 'exists:program_studis,id'],
            'nim'              => ['sometimes', 'string', 'max:20', Rule::unique('mahasiswas', 'nim')->ignore($id)],
            'nama'             => ['sometimes', 'string', 'max:100'],
            'email'            => ['sometimes', 'email', 'max:100', Rule::unique('mahasiswas', 'email')->ignore($id)],
            'angkatan'         => ['sometimes', 'integer', 'min:2000', 'max:2100'],
            'ipk'              => ['sometimes', 'numeric', 'min:0', 'max:4'],
            'aktif'            => ['sometimes', 'boolean'],
        ];
    }
}