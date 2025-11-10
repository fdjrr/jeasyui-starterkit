@php
    $defaultClass = 'easyui-dialog';
@endphp

<div {{ $attributes->merge(['class' => $defaultClass]) }}>{{ $slot }}</div>