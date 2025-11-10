@php
    $defaultClass = 'easyui-progressbar';
@endphp

<div {{ $attributes->merge(['class' => $defaultClass]) }}>{{ $slot }}</div>