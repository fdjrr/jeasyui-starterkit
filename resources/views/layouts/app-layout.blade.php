@props([
    'title' => config('app.name'),
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/metro/easyui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/icon.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div id="cc" class="easyui-layout" data-options="fit:true">
        <div data-options="region:'west',split:true,collapsed:true,
                hideExpandTool: true,
                expandMode: null,
                hideCollapsedContent: false,
                collapsedSize: 68,
                collapsedContent: function(){
                    return $('#titlebar');
                }
                "
            title="West" style="width:100px;"></div>
        <div data-options="region:'center'">
            <div id="tt" class="easyui-tabs" data-options="fit:true"></div>
        </div>
    </div>
    <div id="titlebar" style="padding:2px">
        <a href="javascript:void(0)" class="easyui-linkbutton" style="width:100%"
            data-options="iconCls:'icon-large-shapes',size:'large',iconAlign:'top'"
            onclick="addTab('Data Transaksi', '{{ route('transactions.index') }}')">Trx</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" style="width:100%"
            data-options="iconCls:'icon-large-smartart',size:'large',iconAlign:'top'"
            onclick="addTab('Master Produk', '{{ route('products.index') }}')">Product</a>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.easyui.min.js') }}"></script>

    <script>
        function addTab(title, url) {
            if ($('#tt').tabs('exists', title)) {
                $('#tt').tabs('select', title);
            } else {
                var content =
                    `<iframe scrolling="auto" frameborder="0" src="${url}" style="width:100%;height:100%;"></iframe>`;
                $('#tt').tabs('add', {
                    title: title,
                    content: content,
                    closable: true
                });
            }
        }
    </script>
</body>

</html>
