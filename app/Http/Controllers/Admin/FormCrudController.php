<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FormExport;
use App\Imports\FormImport;
use App\Http\Requests\FormRequest;
use App\Models\VacinationPlace;
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

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */




    public function setup()
    {
        CRUD::setModel(\App\Models\Form::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/form');
        CRUD::setEntityNameStrings('form', 'Formulário');
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

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */

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

    }

    protected function setupListOperation()
    {
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addColumn(['name' => 'prioritygroup', 'type' => 'relationship', 'label' => 'Grupo prioritário']);
        $this->crud->addButtonFromView('top', 'Exportar', 'export', 'beginning');
        $this->crud->addButtonFromView('top', 'Importar', 'import', 'beginning');

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(FormRequest::class);


        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
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
        ]);

    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
/*

    }*/

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
        /*
        $a = $request->input('initial_date');
        $b = $request->input('final_date');
        return (new FormExport($a, $b))->download('vacinometrocovid19_'.$a.'_to_'.$b.'.csv');
        return view("crud::export");"
        */
        if($request->hasFile('file')) {
            (new FormImport)->import($request->file('file'));
        }
        return redirect()->route('form.index');

    }
}
