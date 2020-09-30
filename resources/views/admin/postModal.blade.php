@extends('admin.layout')

@section('content')
<script>
    @if(isset($type) && $type == 'item')
        window.opener.app.$refs['calendar'].setItemData(@json($data));
    @elseif(isset($type) && $type == 'subitem')
        window.opener.app.$refs['calendar'].setSubitemData(@json($data));
    @else
        window.opener.app.$refs['calendar'].setGroupData(@json($data));
    @endif
</script>
@endsection
