@php
    $defaultClass = 'easyui-combobox';
@endphp

<select {{ $attributes->merge(['class' => $defaultClass]) }}>{{ $slot }}</select>