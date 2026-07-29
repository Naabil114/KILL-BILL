<?php

namespace App\Actions\Sertifikat;

use App\Models\SertifikatModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

class Create
{
    /**
     * Validate and create a new sertifikat.
     *
     * @param  array<string, mixed>  $input
     */
    public function create(array $input): SertifikatModel
    {
        $data = Validator::make($input, [
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'string', 'max:255'],
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ])->validate();

        /** @var UploadedFile $photo */
        $photo = $data['foto'];
        $data['foto'] = $photo->store('sertifikat', 'public');

        return SertifikatModel::create($data);
    }
}
