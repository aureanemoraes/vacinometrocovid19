<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultPg extends Model
{
    use HasFactory;
    protected $table = 'results_pg';
    protected $fillable = ['name', 'qtd', 'qtd_2'];
}
