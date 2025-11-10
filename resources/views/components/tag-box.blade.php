@php
    $defaultClass = 'easyui-tagbox';
@endphp

<input {{ $attributes->merge(['class' => $defaultClass]) }}>
