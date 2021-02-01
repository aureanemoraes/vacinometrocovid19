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
        CRUD::setEntityNameStrings('vaccination', 'vaccinations');
    }

    public function fetchHealthProfessional()
    {
        return $this->fetch([
            'model' => \App\Models\HealthProfessional::class, // required
            'searchable_attributes' => ['name', 'cpf']
        ]);
    }

    protected function setupListOperation()
    {
        CRUD::column('name');
        CRUD::column('dose');
        CRUD::column('application_date');
        CRUD::column('lot');
        CRUD::column('lab');
        CRUD::column('form_id');
        CRUD::column('cpf_professional_health');
        CRUD::column('name_professional_health');

    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(VaccinationRequest::class);
        $this->crud->addSaveAction([
            'name' => 'save_action_one',
            'redirect' => function($crud, $request, $itemId) {
                return route('form.index');
            }, // what's the redirect URL, where the user will be taken after saving?
            'order' => 1, // change the order save actions are in
        ]);

        $immunized = Form::find(request()->query('form_id'));
        if(isset($immunized)) {
            CRUD::addField([   // CustomHTML
                'name'  => 'form_info',
                'type'  => 'custom_html',
                'value' => "<h4 align='center'>Imunizado: <strong>$immunized->name - $immunized->cpf</strong> </h4>"
            ]);
        }



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
        $this->setupCreateOperation();
    }
}
