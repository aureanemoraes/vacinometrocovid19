<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VaccinationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class VaccinationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VaccinationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Vaccination::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/vaccination');
        CRUD::setEntityNameStrings('vaccination', 'vaccinations');
    }

    protected function setupListOperation()
    {

    }

    protected function setupCreateOperation()
    {/*
        protected $fillable = [
        'name',
        'dose',
        'application_date',
        'lot',
        'lab',
        'form_id',
        'health_professional_id'
    ];*/

        CRUD::setValidation(VaccinationRequest::class);
        CRUD::addField(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addField(['name' => 'dose', 'type' => 'text', 'label' => 'Dose']);
        CRUD::addField(['name' => 'application_date', 'type' => 'date', 'label' => 'Data de aplicação']);
        CRUD::addField(['name' => 'lot', 'type' => 'text', 'label' => 'Lote']);
        CRUD::addField(['name' => 'lab', 'type' => 'text', 'label' => 'Laboratório']);
        CRUD::addField([
            'type' => "relationship",
            'label' => 'Profissional de saúde',
            'name' => 'health_professional', // the method on your model that defines the relationship,
            //'data_source' =>  route('form.fetchHealthProfessionalPlace'),
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

        //CRUD::addField(['name' => 'health_professional', 'type' => 'relationship', 'label' => 'Profissional de saúde', 'attribute' => 'name' . '-' . 'cpf']);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
