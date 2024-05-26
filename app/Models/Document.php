<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'jenis_document_id',
        'semester',
        'tahun_ajaran',
        'judul_aplikasi',
        'status_usulan'
    ];

    public function mhsDocuments()
    {
        return $this->hasMany(MhsDocument::class);
    }
}
