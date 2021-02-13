<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $table = 'phones';

    protected $fillable = ['number', 'type', 'person', 'form_id'];

    public function form() {
        return $this->belongsTo(Form::class);
    }
}
