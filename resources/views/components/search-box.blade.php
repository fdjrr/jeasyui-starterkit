@php
    $defaultClass = 'easyui-searchbox';
@endphp

<input {{ $attributes->merge(['class' => $defaultClass]) }}>
