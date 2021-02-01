<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FormExport;
use App\Imports\FormImport;
use App\Http\Requests\FormRequest;
use App\Models\VacinationPlace;
use App\Models\HealthProfessional;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class FormCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FormCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $user = backpack_user();
        if (!$user->hasRole('admin')) {
            $this->crud->denyAccess('delete');
        }

        


        CRUD::setModel(\App\Models\Form::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/form');
        CRUD::setEntityNameStrings('Formulário', 'Formulário');
    }

    public function fetchVacinationPlace()
    {
        return $this->fetch([
            'model' => \App\Models\VacinationPlace::class, // required
            'searchable_attributes' => ['name']
        ]);
    }

    public function fetchPriorityGroup()
    {
        return $this->fetch([
            'model' => \App\Models\PriorityGroup::class, // required
            'searchable_attributes' => ['name']
        ]);
    }

    protected function setupShowOperation() {
        //$this->crud->addButtonFromModelFunction('bottom', 'Vacina', '$model_function_name', $position);
        $this->crud->set('show.setFromDb', false);
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addColumn(['name' => 'prioritygroup', 'type' => 'relationship', 'label' => 'Grupo prioritário']);
        CRUD::addColumn([
            'name'  => 'vaccinations_data',
            'label' => 'Vacinas',
            'type'  => 'table',
            'columns' => [
                'name_vaccine'  => 'Nome',
                'dose_vaccine'  => 'Dose',
                'application_date_vaccine' => 'Data de aplicação',
                'lot_vaccine' => 'Lote',
                'lab_vaccine' => 'Laboratório',
                'cpf_professional_health_vaccine' => 'CPF (profissional de saúde)',
                'name_professional_health_vaccine' => 'Nome (profissional de saúde)'
            ]
        ]);
        CRUD::addColumn(['name' => 'age_formatted', 'type' => 'text', 'label' => 'Idade']);
        CRUD::addColumn(['name' => 'user', 'type' => 'relationship', 'label' => 'Criado por', 'attribute' => 'name']);


    }

    protected function setupListOperation()
    {  
        $this->crud->addClause('where', 'user_id', '=', backpack_user()->id);
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addColumn(['name' => 'prioritygroup', 'type' => 'relationship', 'label' => 'Grupo prioritário']);
        $user = backpack_user();
        if ($user->hasRole('admin')) {
            $this->crud->addButtonFromView('top', 'Exportar', 'export', 'beginning');
        }

        $this->crud->addButtonFromView('top', 'Importar', 'import', 'beginning');

    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(FormRequest::class);

        CRUD::addField(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addField(['name' => 'cpf', 'type' => 'text', 'label' => 'CPF']);

        CRUD::addField([   // date_picker
            'name'  => 'birthdate',
            'type'  => 'date',
            'label' => 'Data de nascimento',
        ]);

        CRUD::addField([
            'name'        => 'gender',
            'label'       => "Gênero",
            'type'        => 'select2_from_array',
            'options'     => ['Masculino' => 'Masculino', 'Feminino' => 'Feminino'],
            'allows_null' => true,
        ]);

        CRUD::addField([
            'name' => 'public_place',
            'label' => 'Logradouro',
            'type' => 'text'
        ]);

        CRUD::addField([
            'name' => 'place_number',
            'label' => 'Número',
            'type' => 'text'
        ]);
        CRUD::addField([
            'name' => 'neighborhood',
            'label' => 'Bairro',
            'type' => 'text'
        ]);

        CRUD::addField([
            'name'        => 'city',
            'label'       => "Município",
            'type'        => 'select2_from_array',
            'options'     => [
                'Amapá' => 'Amapá',
                'Calçoene' => 'Calçoene',
                'Cutias' => 'Cutias',
                'Ferreira Gomes' => 'Ferreira Gomes',
                'Itaubal' => 'Itaubal',
                'Laranjal do Jari' => 'Laranjal do Jari',
                'Macapá' => 'Macapá',
                'Mazagão' => 'Mazagão',
                'Oiapoque' => 'Oiapoque',
                'Pedra Branca do Amapari' => 'Pedra Branca do Amapari',
                'Porto Grande' => 'Porto Grande',
                'Pracuúba' => 'Pracuúba',
                'Santana' => 'Santana',
                'Serra do Navio' => 'Serra do Navio',
                'Tartarugalzinho' => 'Tartarugalzinho',
                'Vitória do Jari' => 'Vitória do Jari'
            ],
            'allows_null' => true,
        ]);

        CRUD::addField([
            'type' => "relationship",
            'label' => 'Grupo prioritário',
            'name' => 'prioritygroup_id', // the method on your model that defines the relationship,
            'data_source' =>  route('form.fetchPriorityGroup'),
            'ajax' => true,
            'inline_create' => [ // specify the entity in singular
                'modal_route' => route('prioritygroup-inline-create'), // InlineCreate::getInlineCreateModal()
                'create_route' =>  route('prioritygroup-inline-create-save'),
                'entity' => 'prioritygroup', // the entity in singular
                // OPTIONALS
                'force_select' => true, // should the inline-created entry be immediately selected?
                'modal_class' => 'modal-dialog modal-xl', // use modal-sm, modal-lg to change width
            ],
        ]);

        CRUD::addField([
            'type' => "relationship",
            'label' => 'Local de vacinação',
            'name' => 'vacinationplace_id', // the method on your model that defines the relationship,
            'data_source' =>  route('form.fetchVacinationPlace'),
            'ajax' => true,
            'inline_create' => [ // specify the entity in singular
                'modal_route' => route('vacinationplace-inline-create'), // InlineCreate::getInlineCreateModal()
                'create_route' =>  route('vacinationplace-inline-create-save'),
                'entity' => 'vacinationplace', // the entity in singular
                // OPTIONALS
                'force_select' => true, // should the inline-created entry be immediately selected?
                'modal_class' => 'modal-dialog modal-xl', // use modal-sm, modal-lg to change width
            ],
        ]);
/*
        CRUD::addField([   // Table
            'name'            => 'vaccinations_data',
            'label'           => 'Vacinação',
            'type'            => 'table',
            'columns'         => [
                'name_vaccine'  => 'Nome',
                'dose_vaccine'  => 'Dose',
                'application_date_vaccine' => 'Data de aplicação',
                'lot_vaccine' => 'Lote',
                'lab_vaccine' => 'Laboratório',
                'cpf_professional_health_vaccine' => 'CPF (profissional de saúde)',
                'name_professional_health_vaccine' => 'Nome (profissional de saúde)'
            ],
            'max' => 1, // maximum rows allowed in the table
            'min' => 1, // minimum rows allowed in the table
        ]);*/

        $this->crud->addField([
            'type' => "select_from_array",
            'label' => 'Selecione um profissional cadastrado',
            'name' => 'hp_data', // the method on your model that defines the relationship,
            'allows_null' => true,
            'options' => HealthProfessional::all()->pluck('cpf')->toArray(),
            'tab' => 'Profissional de saúde',

        ]);

        $this->crud->addField([
                'type' => "text",
                'label' => 'Nome',
                'name' => 'hp_name', // the method on your model that defines the relationship,
                'tab' => 'Profissional de saúde',
        ]);

        $this->crud->addField([
            'type' => "text",
            'label' => 'CPF',
            'name' => 'hp_cpf', // the method on your model that defines the relationship,
            'tab' => 'Profissional de saúde',
        ]);

        $this->crud->addField([
            'type' => "select2_from_array",
            'label' => 'Nome',
            'name' => 'v_name', // the method on your model that defines the relationship,
            'options' => ['CoronaVac/SinoVac' => 'CoronaVac/SinoVac', 'AstraZeneca/Oxford' => 'AstraZeneca/Oxford'],
            'tab' => 'Vacinação',
        ]);

        $this->crud->addField([
            'type' => "text",
            'label' => 'Dose',
            'default' => '1ª',
            'name' => 'v_dose', // the method on your model that defines the relationship,
            'tab' => 'Vacinação',
        ]);

        $this->crud->addField([
            'type' => "date",
            'label' => 'Data de aplicação',
            'name' => 'v_application_date', // the method on your model that defines the relationship,
            'tab' => 'Vacinação',
        ]);

        $this->crud->addField([
            'type' => "text",
            'label' => 'Lote',
            'name' => 'v_lot', // the method on your model that defines the relationship,
            'tab' => 'Vacinação',
        ]);

        $this->crud->addField([
            'type' => "select2_from_array",
            'label' => 'Laboratório',
            'name' => 'v_lab', // the method on your model that defines the relationship,
            'options' => ['Insituto Butantan' => 'Insituto Butantan', 'Fiocruz' => 'Fiocruz'],

            'tab' => 'Vacinação',
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function exportView()
    {
        return view("crud::export");
    }

    public function export(Request $request)
    {
        $a = $request->input('initial_date');
        $b = $request->input('final_date');

        return (new FormExport($a, $b))->download('vacinometrocovid19_'.$a.'_to_'.$b.'.csv');
        return view("crud::export");
    }

    public function importView()
    {
        return view("crud::import");
    }

    public function import(Request $request)
    {
        if($request->hasFile('file')) {
            (new FormImport)->import($request->file('file'));
        }
        return redirect()->route('form.index');

    }
}
