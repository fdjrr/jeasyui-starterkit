@php
    $defaultClass = 'easyui-switchbutton';
@endphp

<input {{ $attributes->merge(['class' => $defaultClass]) }}>
