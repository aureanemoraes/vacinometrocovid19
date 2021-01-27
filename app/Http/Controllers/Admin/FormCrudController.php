<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FormExport;
use App\Http\Requests\FormRequest;
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
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
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
        CRUD::setEntityNameStrings('form', 'forms');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addColumn(['name' => 'priority_group', 'type' => 'text', 'label' => 'Grupo prioritário']);
        $this->crud->addButtonFromView('top', 'Exportar', 'export', 'beginning');


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
        CRUD::addField(['name' => 'age', 'type' => 'text', 'label' => 'Idade']);
        CRUD::addField([
            'name' => 'priority_group',
            'type' => 'select2_from_array',
            'options' => [
                'Trabalhadores da área de saúde' => 'Trabalhadores da área de saúde',
                'Idosos (acima de 60 anos)' => 'Idosos (acima de 60 anos)',
                'Indígenas' => 'Indígenas',
                'Pessoas com comorbidades' => 'Pessoas com comorbidades',
                'Professores (do nível básico ao superior)' => 'Professores (do nível básico ao superior)',
                'Comunidades tradicionais ribeirinhas' => 'Quilombolas',
                'Trabalhadores do transporte coletivo' => 'Trabalhadores do transporte coletivo',
                'Pessoas em situação de rua' => 'Pessoas em situação de rua',
                'População privada de liberdade' => 'População privada de liberdade'
            ],
            'allows_null' => false,
            'label' => 'Grupo prioritário',
            'attributes' => [
                'placeholder' => 'Selecione...'
            ]
        ]);

        CRUD::addField([
            'name' => 'gender',
            'type' => 'select2_from_array',
            'options' => [
                'Feminino' => 'Feminino',
                'Masculino' => 'Masculino',
                'Outros' => 'Outros'
            ],
            'allows_null' => false,
            'label' => 'Gênero',
            'attributes' => [
                'placeholder' => 'Selecione...'
            ]
        ]);

        CRUD::addField([
            'name'          => 'public_place',
            'label'         => 'Endereço',
            'type'          => 'address_algolia',
            // optional
            'store_as_json' => true
        ]);

        CRUD::addField([
            'name'          => 'number',
            'label'         => 'Número',
            'type'          => 'text',
        ]);

        CRUD::addField([
            'name'          => 'vacination_place',
            'label'         => 'Lugar de vacinação',
            'type'          => 'text'
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

    public function exportView()
    {
        return view("crud::export");
    }

    public function export(Request $request)
    {
        $a = $request->input('initial_date');
        $b = $request->input('final_date');
        return (new FormExport($a, $b))->download('invoices.xlsx');
        return view("crud::export");
    }
}
