<?php

namespace App\Models;

use App\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory, BelongsToChurch;

    protected $fillable = [
        'church_id',
        'department_id',
        'title',
        'description',
        'category',
        'file_path',
        'file_name',
        'file_extension',
        'file_size_bytes',
        'access_level', // public, members, department, leaders, admin
        'uploaded_by',
        'download_count',
    ];

    protected $casts = [
        'file_size_bytes' => 'integer',
        'download_count' => 'integer',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function fileSizeFormatted(): string
    {
        $bytes = $this->file_size_bytes;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        }
        return $bytes . ' B';
    }
}
