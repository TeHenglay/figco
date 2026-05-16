<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['user_id', 'name', 'figma_file_key'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function components()
    {
        return $this->hasMany(Component::class);
    }
}
