@php
    $defaultClass = 'easyui-window';
@endphp

<div {{ $attributes->merge(['class' => $defaultClass]) }}>
    {{ $slot }}
</div>