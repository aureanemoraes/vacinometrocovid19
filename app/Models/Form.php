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
        'city',
        'vaccinations_data'
    ];
    // protected $hidden = [];
    protected $dates = ['birthdate'];
    protected $casts = ['vaccinations_data' => 'array'];


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::creating(function ($form) {
            // EXPORT
            if($form['gender'] =='') $form->gender = 'Não informado';
            if($form['cpf'] =='') $form->cpf = 'Não informado';

            if($form['public_place'] == '') $form->public_place = 'Não informado';
            if($form['place_number'] == '') $form->place_number = 'Não informado';
            if($form['neighborhood'] == '') $form->neighborhood = 'Não informado';
            if($form['state'] == '') $form->state = 'Não informado';
            if($form['city'] == '') $form->city = 'Não informado';
            if($form['vaccinations_data'] == '') $form->vaccinations_data = 'Não informado';

            $vacinationplace = VacinationPlace::where('name', $form['vacinationplace_id'])->first();
            if(isset($vacinationplace->id)) {
                $form->vacinationplace_id = $vacinationplace->id;
            } else {
                //dd($form['vacinationplace_id']);
                if(isset($form['vacinationplace_id'])) {
                    $newvacinationplace = VacinationPlace::create([
                        'name' => $form['vacinationplace_id']
                    ]);
                    $form->vacinationplace_id = $newvacinationplace->id;
                }

            }

            $prioritygroup = Prioritygroup::where('name', $form['prioritygroup_id'])->first();
            if(isset($prioritygroup->id)) {
                $form->prioritygroup_id = $prioritygroup->id;
            } else {
                if(isset($form['prioritygroup_id'])) {
                    $newprioritygroup = Prioritygroup::create([
                        'name' => $form['prioritygroup_id']
                    ]);
                    $form->prioritygroup_id = $newprioritygroup->id;
                }
            }
            // EXPORT

            // STORING NEW FORM
            //dd($form);
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
        return $this->belongsTo(PriorityGroup::class, 'prioritygroup_id', 'id');
    }

    public function vaccinations() {
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
