@php
    $defaultClass = 'easyui-tabs';
@endphp

<div {{ $attributes->merge(['class' => $defaultClass]) }}>{{ $slot }}</div>