@php
    $defaultClass = 'easyui-maskedbox';
@endphp

<input {{ $attributes->merge(['class' => $defaultClass]) }}>
