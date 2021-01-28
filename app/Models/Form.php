<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\VacinationPlace;
use App\Models\PriorityGroup;


class Form extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'forms';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'age',
        'vacinationplace_id',
        'prioritygroup_id',
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::creating(function ($form) {
            // EXPORT
            
            $vacinationplace = VacinationPlace::where('name', $form['vacinationplace_id'])->first();
            if(isset($vacinationplace->id)) {
                $form->vacinationplace_id = $vacinationplace->id;
            } else {
                $newvacinationplace = VacinationPlace::create([
                    'name' => $form['vacinationplace_id']
                ]);
                $form->vacinationplace_id = $newvacinationplace->id;
            }

            $prioritygroup = Prioritygroup::where('name', $form['prioritygroup_id'])->first();
            if(isset($prioritygroup->id)) {
                $form->prioritygroup_id = $prioritygroup->id;
            } else {
                $newprioritygroup = Prioritygroup::create([
                    'name' => $form['prioritygroup_id']
                ]);
                $form->prioritygroup_id = $newprioritygroup->id;
            }
            // EXPORT

        
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function vacinationplace() {
        return $this->belongsTo(VacinationPlace::class, 'vacinationplace_id', 'id');
    }

    public function prioritygroup() {
        return $this->belongsTo(Prioritygroup::class, 'prioritygroup_id', 'id');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
