<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MhsDocument extends Model
{
    use HasFactory;

    protected $fillable = ['document_id', 'file_code'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}