@if ($crud->hasAccess('create'))
    <a href="{{ route('vaccination.create', ['form_id' => $entry->getKey()])  }}" class="btn btn-sm btn-link pr-0" data-style="zoom-in"><span class="ladda-label"><i class="la la-plus"></i> Adicionar vacina</span></a>
@endif
