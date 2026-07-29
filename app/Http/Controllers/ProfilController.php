<?php

namespace App\Http\Controllers;

use App\Actions\Profil\Create;
use App\Actions\Profil\Update;
use App\Models\ProfilModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    private function photoUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return '/storage/'.ltrim($path, '/');
    }

    public function index()
    {
        try {

            $profil = ProfilModel::latest()
                ->paginate(10)
                ->through(function (ProfilModel $profil) {
                    return [
                        'id' => $profil->id,
                        'nama_profil' => $profil->nama_profil,
                        'email' => $profil->email,
                        'no_hp' => $profil->no_hp,
                        'alamat' => $profil->alamat,
                        'linkedin' => $profil->linkedin,
                        'github' => $profil->github,
                        'foto_profil' => $profil->foto_profil,
                        'foto_profil_url' => $this->photoUrl($profil->foto_profil),
                    ];
                });

            // dd($profil);

            return inertia('profil/Index', [
                'profil' => $profil,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Terjadi kesalahan saat memuat profil.');
        }
    }

    public function store(Request $request, Create $createAction)
    {
        $createAction->create($request->all());

        return redirect()->route('profil.index')->with('success', 'Profil berhasil ditambahkan.');
    }

    public function edit(ProfilModel $profil)
    {
        try {

            return inertia('profil/Edit', [
                'profil' => [
                    'id' => $profil->id,
                    'nama_profil' => $profil->nama_profil,
                    'email' => $profil->email,
                    'no_hp' => $profil->no_hp,
                    'alamat' => $profil->alamat,
                    'linkedin' => $profil->linkedin,
                    'github' => $profil->github,
                    'foto_profil' => $profil->foto_profil,
                    'foto_profil_url' => $this->photoUrl($profil->foto_profil),
                ],
            ]);
        } catch (\Exception $e) {
            return redirect()->route('profil.index')->with('error', 'Terjadi kesalahan saat memuat profil.');
        }
    }

    public function update(Request $request, ProfilModel $profil, Update $updateAction)
    {
        $updateAction->update($request->all(), $profil);

        return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function destroy(ProfilModel $profil)
    {
        try {

            $photo = $profil->foto_profil;
            $profil->delete();

            if ($photo) {
                Storage::disk('public')->delete($photo);
            }

            return redirect()->route('profil.index')->with('success', 'Profil berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('profil.index')->with('error', 'Terjadi kesalahan saat menghapus profil.');
        }
    }
}
