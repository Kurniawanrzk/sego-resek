<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komen extends Model
{
    use HasFactory;
    protected $table = "komen";
    protected $primaryKey = "id_komen";
    protected $fillable = [
        "komen"
    ];
    public $timestamps = false;

}
