<?php

namespace App\Http\Controllers;

use App\Models\ProfilModel;
use App\Models\SertifikatModel;
use Inertia\Inertia;
use Inertia\Response;

class LandingPageController extends Controller
{
    public function __invoke(): Response
    {
        $profil = ProfilModel::latest()->first();

        return Inertia::render('Welcome', [
            'profil' => $profil ? [
                'nama_profil' => $profil->nama_profil,
                'email' => $profil->email,
                'no_hp' => $profil->no_hp,
                'alamat' => $profil->alamat,
                'linkedin' => $profil->linkedin,
                'github' => $profil->github,
                'foto_profil_url' => $this->photoUrl($profil->foto_profil),
            ] : null,
            'sertifikats' => SertifikatModel::latest()->get()->map(fn (SertifikatModel $sertifikat) => [
                'id' => $sertifikat->id,
                'nama' => $sertifikat->nama,
                'deskripsi' => $sertifikat->deskripsi,
                'jenis' => $sertifikat->jenis,
                'foto_url' => $this->photoUrl($sertifikat->foto),
            ]),
        ]);
    }

    private function photoUrl(?string $path): ?string
    {
        return $path ? '/storage/'.ltrim($path, '/') : null;
    }
}
