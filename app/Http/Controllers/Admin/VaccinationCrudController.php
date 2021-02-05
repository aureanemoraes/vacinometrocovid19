<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VaccinationRequest;
use App\Models\Form;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class VaccinationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Vaccination::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/vaccination');
        CRUD::setEntityNameStrings('vacinações', 'Vacinações');
    }

    public function fetchHealthProfessional()
    {
        return $this->fetch([
            'model' => \App\Models\HealthProfessional::class, // required
            'searchable_attributes' => ['name', 'cpf']
        ]);
    }

    protected function setupShowOperation() {
        if($this->crud->getCurrentEntry()->id != backpack_user()->id) {
            $this->crud->denyAccess('show');
        }

        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addColumn(['name' => 'dose', 'type' => 'text', 'label' => 'Dose']);
        CRUD::addColumn(['name' => 'application_date', 'type' => 'date', 'label' => 'Data de aplicação']);
        CRUD::addColumn(['name' => 'lab', 'type' => 'text', 'label' => 'Laboratório']);
        CRUD::addColumn(['name' => 'form', 'type' => 'relationship', 'label' => 'Imunizado', 'attribute' => 'name']);
    }

    protected function setupListOperation()
    {
        if(!backpack_user()->hasRole('admin')) {
            $this->crud->addClause('where', 'user_id', '=', backpack_user()->id);
        }

        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addColumn(['name' => 'dose', 'type' => 'text', 'label' => 'Dose']);
        CRUD::addColumn(['name' => 'application_date', 'type' => 'date', 'label' => 'Data de aplicação']);
        CRUD::addColumn(['name' => 'lab', 'type' => 'text', 'label' => 'Laboratório']);
        CRUD::addColumn(['name' => 'form', 'type' => 'relationship', 'label' => 'Imunizado', 'attribute' => 'name']);


    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(VaccinationRequest::class);
        $this->crud->addSaveAction([
            'name' => 'Salvar e finalizar',
            'redirect' => function($crud, $request, $itemId) {
                return route('form.index');
            }, // what's the redirect URL, where the user will be taken after saving?
            'order' => 1, // change the order save actions are in
        ]);

        $form_id = request()->query('form_id');
        $immunized = Form::find($form_id);
        if(!($immunized->user_id == backpack_user()->id)) {
            $this->crud->denyAccess('create');

        }
        if(isset($immunized)) {
            CRUD::addField([   // CustomHTML
                'name'  => 'form_info',
                'type'  => 'custom_html',
                'value' => "<h4 align='center'>Imunizado: <strong>$immunized->name - $immunized->cpf</strong> </h4>"
            ]);
        }

        CRUD::addField([
            'type' => "hidden",
            'label' => 'Imunizado',
            'name' => 'form_id', // the method on your model that defines the relationship,
            'value' => $form_id
        ]);

        CRUD::addField([
            'type' => "hidden",
            'label' => 'Criado por',
            'name' => 'user_id', // the method on your model that defines the relationship,
            'value' => backpack_user()->id
        ]);

        CRUD::addField([
            'type' => "relationship",
            'label' => 'Profissional de saúde (aplicou a vacina)',
            'name' => 'health_professional', // the method on your model that defines the relationship,
            'data_source' =>  route('vaccination.fetchHealthProfessional'),
            'ajax' => true,
            'inline_create' => [ // specify the entity in singular
                'modal_route' => route('healthprofessional-inline-create'), // InlineCreate::getInlineCreateModal()
                'create_route' =>  route('healthprofessional-inline-create-save'),
                'entity' => 'healthprofessional', // the entity in singular
                // OPTIONALS
                'force_select' => true, // should the inline-created entry be immediately selected?
                'modal_class' => 'modal-dialog modal-xl', // use modal-sm, modal-lg to change width
            ],
        ]);

        CRUD::addField([
            'type' => "select2_from_array",
            'label' => 'Nome',
            'name' => 'name', // the method on your model that defines the relationship,
            'options' => ['CoronaVac/SinoVac' => 'CoronaVac/SinoVac', 'AstraZeneca/Oxford' => 'AstraZeneca/Oxford'],
        ]);

        CRUD::addField([
            'type' => "text",
            'label' => 'Dose',
            'default' => '1ª',
            'name' => 'dose', // the method on your model that defines the relationship,
        ]);

        CRUD::addField([
            'type' => "date",
            'label' => 'Data de aplicação',
            'name' => 'application_date', // the method on your model that defines the relationship,
        ]);

        CRUD::addField([
            'type' => "text",
            'label' => 'Lote',
            'name' => 'lot', // the method on your model that defines the relationship,
        ]);

        CRUD::addField([
            'type' => "select2_from_array",
            'label' => 'Laboratório',
            'name' => 'lab', // the method on your model that defines the relationship,
            'options' => ['Insituto Butantan' => 'Insituto Butantan', 'Fiocruz' => 'Fiocruz'],
        ]);


    }


    protected function setupUpdateOperation()
    {
        if($this->crud->getCurrentEntry()->user_id != backpack_user()->id) {
            $this->crud->denyAccess('update');
        }

        $this->setupCreateOperation();
    }
}
