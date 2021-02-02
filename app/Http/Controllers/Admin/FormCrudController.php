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
        //dd();
        if(count($this->crud->getCurrentEntry()->vaccinations) == 0) {
            $this->crud->addButtonFromView('line', 'new_vaccine', 'new_vaccine', 'beginning');
        }


        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addColumn(['name' => 'cpf', 'type' => 'text', 'label' => 'CPF']);
        CRUD::addColumn(['name' => 'public_place', 'type' => 'text', 'label' => 'Logradouro']);
        CRUD::addColumn(['name' => 'place_number', 'type' => 'text', 'label' => 'Nº']);
        CRUD::addColumn(['name' => 'neighborhood', 'type' => 'text', 'label' => 'Bairro']);
        CRUD::addColumn(['name' => 'state', 'type' => 'text', 'label' => 'Estado']);
        CRUD::addColumn(['name' => 'city', 'type' => 'text', 'label' => 'Município']);

        CRUD::addColumn([
            'name' => 'prioritygroup',
            'type' => 'relationship', 'label' => 'Grupo prioritário',
            'attribute' => 'name'
        ]);

        CRUD::addColumn([
            'name'  => 'vaccinations_details',
            'label' => 'Vacinas', // Table column heading
            'type'  => 'model_function',
            'function_name' => 'getVaccinationsInfo', // the method in your Model
        ]);
        CRUD::addColumn(['name' => 'age_formatted', 'type' => 'text', 'label' => 'Idade']);
        CRUD::addColumn(['name' => 'user', 'type' => 'relationship', 'label' => 'Criado por', 'attribute' => 'name']);
        CRUD::addColumn(['name' => 'created_at', 'type' => 'date', 'label' => 'Criado em', 'attribute' => 'created_at']);

    }

    protected function setupListOperation()
    {
        $this->crud->addClause('where', 'user_id', '=', backpack_user()->id);
        CRUD::addColumn(['name' => 'id', 'type' => 'text', 'label' => 'Código']);

        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addColumn(['name' => 'prioritygroup', 'type' => 'relationship', 'label' => 'Grupo prioritário']);
        $user = backpack_user();
        if ($user->hasRole('admin')) {
            $this->crud->addButtonFromView('top', 'Exportar', 'export', 'beginning');
            $this->crud->addButtonFromView('top', 'Importar', 'import', 'beginning');
        }


    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(FormRequest::class);

        $this->crud->addSaveAction([
            'name' => 'Salvar e continuar',
            'redirect' => function($crud, $request, $itemId) {
                return route('vaccination.create', ['form_id' => $itemId]);
            }, // what's the redirect URL, where the user will be taken after saving?
            'order' => 1, // change the order save actions are in
        ]);


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
            'options'     => [
                'Masculino' => 'Masculino',
                'Feminino' => 'Feminino',
                'Homem transgênero' => 'Homem transgênero',
                'Mulher transgênero' => 'Mulher transgênero',
                'Homem transexual' => 'Homem transexual',
                'Cisgênero' => 'Cisgênero',
                'Não sei responder' => 'Não sei responder',
                'Prefiro não responder' => 'Prefiro não responder',
                'Outros' => 'Outros'
            ],
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
            'name' => 'state',
            'value' => 'Amapá',
            'type' => 'hidden'
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
            //'ajax' => true,
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
            //'ajax' => true,
            'inline_create' => [ // specify the entity in singular
                'modal_route' => route('vacinationplace-inline-create'), // InlineCreate::getInlineCreateModal()
                'create_route' =>  route('vacinationplace-inline-create-save'),
                'entity' => 'vacinationplace', // the entity in singular
                // OPTIONALS
                'force_select' => true, // should the inline-created entry be immediately selected?
                'modal_class' => 'modal-dialog modal-xl', // use modal-sm, modal-lg to change width
            ],
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
