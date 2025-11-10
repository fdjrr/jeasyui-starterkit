@php
    $defaultClass = 'easyui-numberbox';
@endphp

<input {{ $attributes->merge(['class' => $defaultClass]) }}>
