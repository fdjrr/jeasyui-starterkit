@php
    $defaultClass = 'easyui-datagrid';
@endphp

<table {{ $attributes->merge(['class' => $defaultClass]) }}>{{ $slot }}</table>