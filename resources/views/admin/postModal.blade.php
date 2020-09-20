@extends('admin.layout')

@section('content')
<script>
    window.opener.app.$refs['calendar'].setItemData({{ $id }}, '{{ $name }}')
    window.close()
</script>
@endsection
