@extends('admin.layout')

@section('content')
<script>
    @if(isset($type) && $type == 'item')
        window.opener.app.$refs['calendar'].setItemEditData(@json($data));
    @elseif(isset($type) && $type == 'subitem')
        window.opener.app.$refs['calendar'].setSubitemEditData(@json($data));
    @else
        window.opener.app.$refs['calendar'].setGroupEditData(@json($data));
    @endif
</script>
@endsection
