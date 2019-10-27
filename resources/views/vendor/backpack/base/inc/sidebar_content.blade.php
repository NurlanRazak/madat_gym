<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
<li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
<li><a href='{{ backpack_url('subscription') }}'><i class='fa fa-ticket'></i> <span>{{ trans_choice('admin.subscription', 2) }}</span></a></li>

<li><a href='{{ backpack_url('programtype') }}'><i class='fa fa-tasks'></i> <span>Типы программ</span></a></li>
<li><a href='{{ backpack_url('foodprogram') }}'><i class='fa fa-cutlery'></i> <span>Программа питания</span></a></li>