<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VacinationPlaceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Imports\VacinationPlacesImport;
use Illuminate\Http\Request;


class VacinationPlaceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\VacinationPlace::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/vacinationplace');
        CRUD::setEntityNameStrings('locais de vacinação', 'Locais de vacinação');
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
        $this->crud->addButtonFromView('top', 'Importar', 'import', 'beginning');
        CRUD::addColumn(['name' => 'id', 'type' => 'text', 'label' => 'Código']);
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addColumn(['name' => 'user', 'type' => 'relationship', 'label' => 'Criado por', 'attribute' => 'name']);
    }


    protected function setupListOperation()
    {
        $this->crud->addButtonFromView('top', 'Importar', 'import', 'beginning');

        CRUD::addColumn(['name' => 'id', 'type' => 'text', 'label' => 'Código']);
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(VacinationPlaceRequest::class);

        CRUD::addField(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
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


    public function importView()
    {
        return view("crud::import");
    }

    public function import(Request $request)
    {
        if($request->hasFile('file')) {
            (new VacinationPlacesImport)->import($request->file('file'));
        }
        return redirect()->route('vacinationplace.index');

    }
}
