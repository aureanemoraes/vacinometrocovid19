<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\HealthProfessionalRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class HealthProfessionalCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class HealthProfessionalCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
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
        CRUD::setModel(\App\Models\HealthProfessional::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/healthprofessional');
        CRUD::setEntityNameStrings('profissional de saúde', 'profissionais de saúde');
        $user = backpack_user();
        if (!$user->hasRole('admin')) {
            $this->crud->denyAccess('delete');
        }
        if (!$user->hasRole('admin') && !$user->hasRole('manager')) {
            $this->crud->denyAccess(['list', 'update', 'show']);
        }
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        CRUD::addColumn(['name' => 'id', 'type' => 'text', 'label' => 'Código']);
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addColumn(['name' => 'cpf', 'type' => 'text', 'label' => 'CPF']);
        CRUD::addColumn(['name' => 'user', 'type' => 'relationship', 'label' => 'Criado por', 'attribute' => 'name']);
    }

    protected function setupListOperation()
    {
        CRUD::addColumn(['name' => 'id', 'type' => 'text', 'label' => 'Código']);
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addColumn(['name' => 'cpf', 'type' => 'text', 'label' => 'CPF']);
    }


    protected function setupCreateOperation()
    {
        CRUD::setValidation(HealthProfessionalRequest::class);

        CRUD::addField(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addField(['name' => 'cpf', 'type' => 'text', 'label' => 'CPF']);
        CRUD::addField([
            'type' => "hidden",
            'label' => 'Criado por',
            'name' => 'user_id', // the method on your model that defines the relationship,
            'value' => backpack_user()->id
        ]);


    }


    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
