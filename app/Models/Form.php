<?php

namespace App\Models;


use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
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
        'vaccinations_data',
        'age',
        'user_id',
    ];
    // protected $hidden = [];
    protected $dates = ['birthdate', 'v_application_date'];
    protected $casts = ['vaccinations_data' => 'array'];


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::creating(function ($form) {

            $form->user_id = auth()->user()->id;
            // EXPORT
            if($form['gender'] =='') $form->gender = 'Não informado';
            if($form['cpf'] =='') $form->cpf = 'Não informado';
            if($form['public_place'] == '') $form->public_place = 'Não informado';
            if($form['place_number'] == '') $form->place_number = 'Não informado';
            if($form['neighborhood'] == '') $form->neighborhood = 'Não informado';
            if($form['state'] == '') $form->state = 'Não informado';
            if($form['city'] == '') $form->city = 'Não informado';
            if($form['vaccinations_data'] == '') $form->vaccinations_data = 'Não informado';
            if(isset($form['age'])) {
                $form->age = $form['age'];
            }

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
        });
    }

    public function getVaccinationsInfo() {
        $vaccinations = Vaccination::where('form_id', $this->id)->get();
        $table = '<table><thead><th>Nome</th><th>Laboratório</th><th>Lote</th><th>Dose</th><th>Data de aplicação</th><th>Profissional de saúde</th></thead><tbody>';
        foreach($vaccinations as $vaccination) {
            $table .= "<td>$vaccination->name</td><td>$vaccination->lab</td><td>$vaccination->lot</td><td>$vaccination->dose</td><td>$vaccination->application_date</td><td>$vaccination->health_professional->name</td>";
        }
        $table .= "</tbody></table>";
        return $table;
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

    public function user() {
        return $this->belongsTo(User::class);
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
    public function getAgeFormattedAttribute()
    {
        if(isset($this->attributes['birthdate'])) {
            return Carbon::parse($this->attributes['birthdate'])->age;

        } else {
            return $this->attributes['age'];

        }
    }
}
