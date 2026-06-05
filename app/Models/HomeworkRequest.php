<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeworkRequest extends Model
{
    protected $fillable = [
        'user_id',
        'original_filename',
        'file_path',
        'instructions',
        'status',
        'homework_content',
        'result_pdf_path',
        'result_docx_path',
        'error_message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
