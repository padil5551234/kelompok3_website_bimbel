<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formasi extends Model
{
    use HasFactory;

    protected $table = 'formasi';
    protected $primaryKey = 'kode';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['kode', 'nama'];

    public static function getNama($kode)
    {
        $formasi = self::find($kode);
        return $formasi ? $formasi->nama : null;
    }
}
