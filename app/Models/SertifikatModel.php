<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'deskripsi', 'jenis', 'foto'])]
class SertifikatModel extends Model
{
    protected $table = 'sertifikat';
}
