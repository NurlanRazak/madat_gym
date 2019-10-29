<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
<li class="treeview">
    <a href="#"><i class="fa fa-thumb-tack"></i> <span>Тренировки</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href='{{ backpack_url('subscription') }}'><i class='fa fa-ticket'></i> <span>{{ trans_choice('admin.subscription', 2) }}</span></a></li>
        <li><a href='{{ backpack_url('programtraining') }}'><i class='fa fa-thumb-tack'></i> <span>Программы (тренировки)</span></a></li>
        <li><a href='{{ backpack_url('programtype') }}'><i class='fa fa-tasks'></i> <span>Типы программ</span></a></li>
        <li><a href='{{ backpack_url('activeprogram') }}'><i class='fa fa-toggle-on'></i> <span>Активные программы</span></a></li>
        <li><a href='{{ backpack_url('exercise') }}'><i class='fa fa-sign-language'></i> <span>Упражнения</span></a></li>
    </ul>
</li>
<li class="treeview">
  <a href="#"><i class="fa fa-balance-scale"></i> <span>Питание</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
    <li><a href='{{ backpack_url('foodprogram') }}'><i class='fa fa-cutlery'></i> <span>Программы питания</span></a></li>
    <li><a href='{{ backpack_url('meal') }}'><i class='fa fa-leaf'></i><span>Блюда</span></a></li>
  </ul>
</li>
<li class="treeview">
  <a href="#"><i class="fa fa-bed"></i> <span>Отдых</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
      <li><a href='{{ backpack_url('relaxprogram') }}'><i class='fa fa-bell'></i> <span>Программы отдыха</span></a></li>
  </ul>
</li>

<li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
