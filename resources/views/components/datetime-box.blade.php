@php
    $defaultClass = 'easyui-datetimebox';
@endphp

<input {{ $attributes->merge(['class' => $defaultClass]) }}>
