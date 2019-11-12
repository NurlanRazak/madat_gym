{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}
{{-- GOTO: app/Services/MenuService/Traits/MenuTrait --}}








@foreach(AdminMenuGenerator::getTree() as $menu_item)
    @if(isset($menu_item['sub_items']))
        <li class="treeview">
            <a href="{{ $menu_item['route'] }}"><i class="{{ $menu_item['icon'] }}"></i> <span>{{ $menu_item['label'] }}</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
                @foreach($menu_item['sub_items'] as $sub_item)
                    <li><a href="{{ $sub_item['route'] }}"><i class="{{ $sub_item['icon'] }}"></i> <span>{{ $sub_item['label'] }}</span></a></li>
                @endforeach
            </ul>
        </li>
    @else
        <li><a href="{{ $menu_item['route'] }}"><i class="{{ $menu_item['icon'] }}"></i> <span>{{ $menu_item['label'] }}</span></a></li>
    @endif

@endforeach
