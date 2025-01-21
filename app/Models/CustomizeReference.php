<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomizeReference extends Model
{
    use HasFactory;
    protected $table = "customize_references";
    protected $guarded = [];
}
