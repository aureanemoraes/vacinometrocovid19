<!-- number input -->

<div>
    
    @if(isset($field['prefix']) || isset($field['suffix'])) <div class="input-group"> @endif
        @if(isset($field['prefix'])) <div class="input-group-addon">{!! $field['prefix'] !!}</div> @endif
        <input
            type="number"
            ng-model="item.{{ $field['name'] }}"
            @include('crud::fields.inc.attributes')
        	>
        @if(isset($field['suffix'])) <div class="input-group-addon">{!! $field['suffix'] !!}</div> @endif

    @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>


@if (!$crud->child_resource_included['number'])

    @push('crud_fields_styles')
        <style>
            .table input[type='number'] { text-align: right; padding-right: 5px; }
        </style>
    @endpush

    <?php $crud->child_resource_included['number'] = true; ?>
@endif