@php
    $defaultClass = 'easyui-slider';
@endphp

<input {{ $attributes->merge(['class' => $defaultClass]) }}>
