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
        <li><a href='{{ backpack_url('training') }}'><i class='fa fa-bicycle'></i> <span>Тренировки (программы-упражнения)</span></a></li>
        <li><a href='{{ backpack_url('equipment') }}'><i class='fa fa-gavel'></i> <span>Оборудования</span></a></li>
        <li><a href='{{ backpack_url('grocery') }}'><i class='fa fa-shopping-basket'></i> <span>Продукты для тренировок</span></a></li>
    </ul>
</li>
<li class="treeview">
  <a href="#"><i class="fa fa-balance-scale"></i> <span>Питание</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
    <li><a href='{{ backpack_url('foodprogram') }}'><i class='fa fa-cutlery'></i> <span>Программы питания</span></a></li>
    <li><a href='{{ backpack_url('meal') }}'><i class='fa fa-leaf'></i><span>Блюда</span></a></li>
    <li><a href='{{ backpack_url('eathour') }}'><i class='fa fa-hourglass-half'></i> <span>Часы приема</span></a></li>
    <li><a href='{{ backpack_url('planeat') }}'><i class='fa fa-calendar-plus-o'></i> <span>План питания</span></a></li>
  </ul>
</li>
<li class="treeview">
  <a href="#"><i class="fa fa-bed"></i> <span>Отдых</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
      <li><a href='{{ backpack_url('relaxprogram') }}'><i class='fa fa-bell'></i> <span>Программы отдыха</span></a></li>
      <li><a href='{{ backpack_url('relaxexercise') }}'><i class='fa fa-recycle'></i> <span>Упражнения</span></a></li>
      <li><a href='{{ backpack_url('relaxtraining') }}'><i class='fa fa-bicycle'></i> <span>Тренировки (программы-упражнения)</span></a></li>
  </ul>
</li>
<li class="treeview">
    <a href="#"><i class="fa fa-group"></i> <span>Люди</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('consumer') }}"><i class="nav-icon fa fa-user"></i> <span>Пользователи</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon fa fa-user"></i> <span>Сотрудники</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon fa fa-group"></i> <span>Роли</span></a></li>
    </ul>
</li>
<li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
