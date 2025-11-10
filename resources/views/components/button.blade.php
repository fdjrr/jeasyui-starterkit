@php
    $defaultClass = 'easyui-linkbutton';
@endphp

<a {{ $attributes->merge(['class' => $defaultClass]) }}>{{ $slot }}</a>