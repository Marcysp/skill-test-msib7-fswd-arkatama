<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Travel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'travel';
    protected $dates = ['tanggal_keberangkatan']; // Menandakan bahwa kolom ini adalah tanggal
    protected $guarded = [];
}
