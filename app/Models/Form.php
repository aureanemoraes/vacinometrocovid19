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
        'age',
        'user_id',
        'created_at'
    ];
    // protected $hidden = [];
    protected $dates = ['birthdate', 'created_at'];


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
            if($form['gender'] =='') $form->gender = null;
            if($form['cpf'] =='') $form->cpf = null;
            if($form['public_place'] == '') $form->public_place = null;
            if($form['place_number'] == '') $form->place_number = null;
            if($form['neighborhood'] == '') $form->neighborhood = null;
            if($form['state'] == '') $form->state = null;
            if($form['city'] == '') $form->city = null;
            if($form['vaccinations_data'] == '') $form->vaccinations_data = null;
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
        if(count($vaccinations) > 0) {
            $table = '<table><thead><th>Código</th><th>Nome</th><th>Laboratório</th><th>Lote</th><th>Dose</th><th>Data de aplicação</th><th>Profissional de saúde</th><th>Ações</th></thead><tbody>'; 
            foreach($vaccinations as $vaccination) {
                $application_date_formatted = date_format($vaccination->application_date, 'd/m/Y');
                $health_professional_name = $vaccination->health_professional->name;
                $edit_buttom = "<a href='/admin/vaccination/$vaccination->id/edit ' class='btn btn-sm btn-link'><i class='la la-edit'></i> Alterar</a>";
                $table .= "<td>$vaccination->id</td><td>$vaccination->name</td><td>$vaccination->lab</td><td>$vaccination->lot</td><td>$vaccination->dose</td><td>$application_date_formatted</td><td>$health_professional_name</td><td>$edit_buttom</td>";
            }
            $table .= "</tbody></table>";
            return $table;
        } else {
            return 'Não há vacinação cadastrada.';
        }
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
    public function getAgeFormattedAttribute()
    {
        if(isset($this->attributes['birthdate'])) {
            return Carbon::parse($this->attributes['birthdate'])->age;

        } else {
            return $this->attributes['age'];

        }
    }

    public function getNameFormattedAttribute()
    {
        $pieces = explode(" ", $this->attributes['name']);
        $lastNames = ' ';
        for($i=0 ; $i<count($pieces); $i++) {
            if($i==0) {
                $firstName = strtoupper($pieces[$i]);
            }
            $lastNames .= $pieces[$i][0] . '. ';
            //dd($lastNames);
        }
        $fullName = $firstName . $lastNames;
        return $fullName;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setNameAttribute($value) {
        $this->attributes['name'] = ucwords($value);
    }
    
    public function setPublicPlaceAttribute($value) {
        $this->attributes['public_place'] = ucfirst($value);
    }

    public function setNeighborhoodAttribute($value) {
        $this->attributes['neighborhood'] = ucfirst($value);
    }

}
