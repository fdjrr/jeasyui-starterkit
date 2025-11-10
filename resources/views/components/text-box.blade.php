@php
    $defaultClass = 'easyui-textbox';
@endphp

<input {{ $attributes->merge(['class' => $defaultClass]) }}>