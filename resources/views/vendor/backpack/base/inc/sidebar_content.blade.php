<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('vacinationplace') }}'><i class='nav-icon la la-question'></i> Locais da vacinação</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('form') }}'><i class='nav-icon la la-question'></i> Formulários</a></li>

@if(backpack_user()->is_admin)
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('user') }}'><i class='nav-icon la la-question'></i> Users</a></li>
@endif
