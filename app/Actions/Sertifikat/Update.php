<?php

namespace App\Actions\Sertifikat;

use App\Models\SertifikatModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Update
{
    /**
     * Validate and update an existing sertifikat.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(array $input, SertifikatModel $sertifikat): SertifikatModel
    {
        $data = Validator::make($input, [
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ])->validate();

        $oldPhoto = $sertifikat->foto;

        if (($data['foto'] ?? null) instanceof UploadedFile) {
            $data['foto'] = $data['foto']->store('sertifikat', 'public');
        } else {
            unset($data['foto']);
        }

        $sertifikat->update($data);

        if (isset($data['foto']) && $oldPhoto && $oldPhoto !== $data['foto']) {
            Storage::disk('public')->delete($oldPhoto);
        }

        return $sertifikat;
    }
}
