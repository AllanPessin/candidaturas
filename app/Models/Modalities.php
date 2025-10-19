<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modalities extends Model
{
    use HasFactory;

    protected $table = 'modalities';

    protected $fillable = ['name'];
}
