@php
    $defaultClass = 'easyui-radiobutton';
@endphp

<input {{ $attributes->merge(['class' => $defaultClass]) }}>
