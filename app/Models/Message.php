<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $timestamps = false;

    protected $fillable = ['conversation_id', 'role', 'content'];

    protected function casts(): array
    {
        return ['created_at' => 'datetime'];
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
