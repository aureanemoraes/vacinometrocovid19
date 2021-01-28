<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('vacinationplace') }}'><i class='nav-icon la la-question'></i> Locais da vacinação</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('form') }}'><i class='nav-icon la la-question'></i> Formulários</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('prioritygroup') }}'><i class='nav-icon la la-question'></i> Grupos prioritários</a></li>

@if(backpack_user()->hasRole('admin'))
<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Administração</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Usuários</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Regras</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissões</span></a></li>
    </ul>
</li>
@endif
