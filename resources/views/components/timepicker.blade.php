@php
    $defaultClass = 'easyui-timepicker';
@endphp

<input {{ $attributes->merge(['class' => $defaultClass]) }}>