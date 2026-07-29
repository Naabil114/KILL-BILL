<?php

namespace App\Http\Controllers;

use App\Actions\Sertifikat\Create;
use App\Actions\Sertifikat\Update;
use App\Models\SertifikatModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class SertifikatController extends Controller
{
    public function index(): Response
    {
        $sertifikats = SertifikatModel::latest()->get()->map(function (SertifikatModel $sertifikat) {
            return [
                'id' => $sertifikat->id,
                'nama' => $sertifikat->nama,
                'deskripsi' => $sertifikat->deskripsi,
                'jenis' => $sertifikat->jenis,
                'foto' => $sertifikat->foto,
                'foto_url' => $this->photoUrl($sertifikat->foto),
            ];
        });
        // dd($sertifikats);

        return Inertia::render('sertifikat/Index', [
            'sertifikats' => $sertifikats,
        ]);
    }

    public function store(Request $request, Create $createAction): RedirectResponse
    {
        $createAction->create($request->all());

        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function edit(SertifikatModel $sertifikat): Response
    {
        return Inertia::render('sertifikat/Edit', [
            'sertifikat' => [
                'id' => $sertifikat->id,
                'nama' => $sertifikat->nama,
                'deskripsi' => $sertifikat->deskripsi,
                'jenis' => $sertifikat->jenis,
                'foto' => $sertifikat->foto,
                'foto_url' => $this->photoUrl($sertifikat->foto),
            ],
        ]);
    }

    public function update(Request $request, SertifikatModel $sertifikat, Update $updateAction): RedirectResponse
    {
        $updateAction->update($request->all(), $sertifikat);

        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy(SertifikatModel $sertifikat): RedirectResponse
    {
        $photo = $sertifikat->foto;
        $sertifikat->delete();

        if ($photo) {
            Storage::disk('public')->delete($photo);
        }

        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil dihapus.');
    }

    private function photoUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return '/storage/'.ltrim($path, '/');
    }
}
