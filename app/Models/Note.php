<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'priority',
        'group_id',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
