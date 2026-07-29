<?php

namespace App\Actions\Profil;

use App\Models\ProfilModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

class Create
{
    /**
     * Validate and create a new profil.
     *
     * @param  array<string, mixed>  $input
     */
    public function create(array $input): ProfilModel
    {
        $data = Validator::make($input, [
            'nama_profil' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'linkedin' => ['required', 'string', 'max:255'],
            'github' => ['required', 'string', 'max:255'],
            'foto_profil' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ])->validate();

        /** @var UploadedFile $photo */
        $photo = $data['foto_profil'];
        $data['foto_profil'] = $photo->store('profil', 'public');

        return ProfilModel::create($data);
    }
}
