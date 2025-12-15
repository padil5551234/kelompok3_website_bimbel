<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';
    protected $primaryKey = 'kode';
    protected $keyType = 'integer';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['kode', 'nama'];

    public static function getNama($kode)
    {
        $prodi = self::find($kode);
        return $prodi ? $prodi->nama : null;
    }
}
