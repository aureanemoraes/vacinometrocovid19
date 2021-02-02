<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PriorityGroupRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use App\Imports\PriorityGroupsImport;
/**
 * Class PriorityGroupCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PriorityGroupCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\PriorityGroup::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/prioritygroup');
        CRUD::setEntityNameStrings('prioritygroup', 'Grupos prioritários');
    }

    protected function setupListOperation()
    {
        $this->crud->addButtonFromView('top', 'Importar', 'import', 'beginning');
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);

    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(PriorityGroupRequest::class);
        CRUD::addField(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
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
            (new PriorityGroupsImport)->import($request->file('file'));
        }
        return redirect()->route('prioritygroup.index');

    }
}
