<?php

namespace App\Models;


use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;



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
        'cpf',
        'birthdate',
        'vacinationplace_id',
        'prioritygroup_id',
        'gender',
        'public_place',
        'place_number',
        'neighborhood',
        'state',
        'city'
    ];
    // protected $hidden = [];
    protected $dates = ['birthdate'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::creating(function ($form) {
            // EXPORT
            if($form['gender'] = '') $form->gender = 'Não informado';
            if($form['public_place'] = '') $form->public_place = 'Não informado';
            if($form['place_number'] = '') $form->place_number = 'Não informado';
            if($form['neighborhood'] = '') $form->neighborhood = 'Não informado';
            if($form['state'] = '') $form->state = 'Não informado';
            if($form['city'] = '') $form->city = 'Não informado';

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

    public function vacinations() {
        return $this->hasMany(Vaccination::class, 'form_id', 'id');
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
