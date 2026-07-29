<?php

namespace App\Actions\Profil;

use App\Models\ProfilModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Update
{
    /**
     * Validate and update an existing profil.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(array $input, ProfilModel $profil): ProfilModel
    {
        $data = Validator::make($input, [
            'nama_profil' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'linkedin' => ['required', 'string', 'max:255'],
            'github' => ['required', 'string', 'max:255'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ])->validate();

        $oldPhoto = $profil->foto_profil;

        if (($data['foto_profil'] ?? null) instanceof UploadedFile) {
            $data['foto_profil'] = $data['foto_profil']->store('profil', 'public');
        } else {
            unset($data['foto_profil']);
        }

        $profil->update($data);

        if (isset($data['foto_profil']) && $oldPhoto && $oldPhoto !== $data['foto_profil']) {
            Storage::disk('public')->delete($oldPhoto);
        }

        return $profil;
    }
}
