@php
    $defaultClass = 'easyui-filebox';
@endphp

<input {{ $attributes->merge(['class' => $defaultClass]) }}>
