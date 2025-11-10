@php
    $defaultClass = 'easyui-datebox';
@endphp

<input {{ $attributes->merge(['class' => $defaultClass]) }}>
