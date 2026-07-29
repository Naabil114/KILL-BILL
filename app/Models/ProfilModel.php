<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
#[Fillable(['nama_profil', 'email', 'no_hp', 'alamat', 'linkedin', 'github', 'foto_profil'])]

class ProfilModel extends Model
{
    protected $table = 'profil';
}
