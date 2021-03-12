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
        'gender',
        'public_place',
        'place_number',
        'neighborhood',
        'state',
        'city',
        'age',
        'user_id',
        'created_at',
        'zip_code',
        'bedridden',
        'vaccinated',
        'dose',
        'vacination_place',
        'priority_group',
        'prioritygroup_id',
        'vacinationplace_id'
    ];
    // protected $hidden = [];
    protected $dates = ['birthdate', 'created_at'];
    protected $appends = ['age_formatted', 'name_formatted'];


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::creating(function ($form) {
            $user = auth()->user();
            if(isset($user)) {
                $form->user_id = $user->id;
            }
            // EXPORT

            if(isset($form['age'])) {
                $form->age = $form['age'];
            }

            if(isset($form['vacination_place'])) {
                $vacinationplace = VacinationPlace::where('name', $form['vacination_place'])->first();
                if(isset($vacinationplace->id)) {
                    $form->vacination_place = $vacinationplace->id;
                } else {
                    //dd($form['vacination_place']);
                    if(isset($form['vacination_place'])) {
                        $newvacinationplace = VacinationPlace::create([
                            'name' => $form['vacination_place']
                        ]);
                        $form->vacinationplace_id = $newvacinationplace->id;
                    }
                }
            }

            if(isset($form['priority_group'])) {
                $prioritygroup = PriorityGroup::where('name', $form['priority_group'])->first();
                if(isset($prioritygroup->id)) {
                    $form->priority_group = $prioritygroup->id;
                } else {
                    if(isset($form['priority_group'])) {
                        $newprioritygroup = PriorityGroup::create([
                            'name' => $form['priority_group']
                        ]);
                        $form->prioritygroup_id = $newprioritygroup->id;
                    }
                }
            }

        });
        static::created(function ($form) {
            $result = Result::where('name', $form->vacinationplace->name)->first();

            if($form->dose == 0) {
                if(isset($result)) {
                    $result->qtd++;
                    $result->save();
                } else {
                    Result::create([
                        'name' => $form->vacinationplace->name,
                        'qtd' => 1,
                        'qtd_2' => 0
                    ]);
                }
            } else if($form->dose == 2) {
                if(isset($result)) {
                    $result->qtd_2++;
                    $result->save();
                } else {
                    Result::create([
                        'name' => $form->vacinationplace->name,
                        'qtd' => 0,
                        'qtd_2' => 1
                    ]);
                }
            }

            $result_pg = ResultPg::where('name', $form->prioritygroup->name)->first();
            if($form->dose == 0) {
                if(isset($result_pg)) {
                    $result_pg->qtd++;
                    $result_pg->save();
                } else {
                    ResultPg::create([
                        'name' => $form->prioritygroup->name,
                        'qtd' => 1,
                        'qtd_2' => 0
                    ]);
                }
            } else if($form->dose == 2) {
                if(isset($result_pg)) {
                    $result_pg->qtd_2++;
                    $result_pg->save();
                } else {
                    ResultPg::create([
                        'name' => $form->prioritygroup->name,
                        'qtd_2' => 1,
                        'qtd' => 0
                    ]);
                }
            }
        });
        static::deleted(function ($form) {
            $result = Result::where('name', $form->vacinationplace->name)->first();
            if($form->dose == 0) {
                $result->qtd--;
            } else {
                $result->qtd_2--;
            }
            $result->save();

            $result_pg = ResultPg::where('name', $form->prioritygroup->name)->first();
            if($form->dose == 0) {
                $result_pg->qtd--;
            } else {
                $result_pg->qtd_2--;
            }
            $result_pg->save();
        });
        static::updating(function ($form) {
            if($form->getOriginal('vacinationplace_id') !== $form->vacinationplace_id) {
                $vacinationplace = VacinationPlace::find($form->getOriginal('vacinationplace_id'));

                $result = Result::where('name', $vacinationplace->name)->first();
                $new_result = Result::where('name', $form->vacinationplace->name)->first();

                if (isset($new_result)) {
                    if($form->dose == 0) {
                        $result->qtd--;
                        $new_result->qtd++;
                    } else {
                        $result->qtd_2--;
                        $new_result->qtd_2++;
                    }
                    $new_result->save();
                } else {
                    if($form->dose == 0) {
                        $result->qtd--;
                        Result::create([
                            'name' => $form->vacinationplace->name,
                            'qtd' => 1,
                            'qtd_2' => 0
                        ]);
                    } else if($form->dose == 2) {
                        $result->qtd_2--;
                        Result::create([
                            'name' => $form->vacinationplace->name,
                            'qtd' => 0,
                            'qtd_2' => 1
                        ]);
                    }
                }
                $result->save();
            }

            if($form->getOriginal('prioritygroup_id') !== $form->prioritygroup_id) {
                $prioritygroup = PriorityGroup::find($form->getOriginal('prioritygroup_id'));
                $result_pg = ResultPg::where('name', $prioritygroup->name)->first();
                $new_result_pg = ResultPg::where('name', $form->prioritygroup->name)->first();

                if(isset($new_result_pg)) {
                    if($form->dose == 0) {
                        $result_pg->qtd--;
                        $new_result_pg->qtd++;
                    } else {
                        $result_pg->qtd_2--;
                        $new_result_pg->qtd_2++;
                    }
                    $new_result_pg->save();
                } else {
                    if($form->dose == 0) {
                        $result_pg->qtd--;
                        ResultPg::create([
                            'name' => $form->prioritygroup->name,
                            'qtd' => 1,
                            'qtd_2' => 0
                        ]);
                    } else if($form->dose == 2) {
                        $result_pg->qtd_2--;
                        ResultPg::create([
                            'name' => $form->prioritygroup->name,
                            'qtd_2' => 1,
                            'qtd' => 0
                        ]);
                    }
                }
                $result_pg->save();
            }
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

    public function phones() {
        return $this->hasMany(Phone::class);
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
            } else {
                $lastNames .= $pieces[$i][0] . '. ';

            }
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

    public function setBedriddenAttribute($value) {
        if($value == 'Sim') {
            $this->attributes['bedridden'] = true;
        }
    }

}
