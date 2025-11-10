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
        <div data-options="region:'west',split:true" style="width:300px;">
            <div class="easyui-accordion" data-options="border:false">
                <div title="Transaksi" data-options="selected:false" style="padding:10px;">
                    <ul id="transactionTree" class="easyui-tree">
                        <li data-id="master-stok">Transaksi</li>
                    </ul>
                </div>
                <div title="Master Data" data-options="selected:false" style="padding:10px;">
                    <ul id="masterTree" class="easyui-tree">
                        <li data-id="master-stok">Master Stok</li>
                        <li data-id="master-gudang">Master Gudang</li>
                        <li data-id="master-produk">
                            <span>Master Produk</span>
                            <ul>
                                <li data-id="kategori">Data Produk</li>
                                <li data-id="kategori">Data Kategori</li>
                                <li data-id="unit">Data Unit</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div data-options="region:'center'">
            <div id="tt" class="easyui-tabs" data-options="fit:true"></div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.easyui.min.js') }}"></script>

    <script>
        $('#transactionTree').tree({
            onClick: function(node) {
                switch (node.text) {
                    case 'Transaksi':
                        addTab('Transaksi', "{{ route('transactions.index') }}");
                        break;
                }
            }
        });

        $('#masterTree').tree({
            onClick: function(node) {
                switch (node.text) {
                    case 'Master Stok':
                        addTab('Master Stok', "{{ route('stock_batches.index') }}");
                        break;

                    case 'Master Gudang':
                        addTab('Master Gudang', "{{ route('warehouses.index') }}");
                        break;

                    case 'Data Produk':
                        addTab('Data Produk', "{{ route('products.index') }}");
                        break;

                    case 'Data Kategori':
                        addTab('Data Kategori', "{{ route('product_categories.index') }}");
                        break;

                    case 'Data Unit':
                        addTab('Data Unit', "{{ route('product_units.index') }}");
                        break;
                }
            }
        });

        function addTab(title, url) {
            if ($('#tt').tabs('exists', title)) {
                $('#tt').tabs('select', title);
            } else {
                var content =
                    `<iframe scrolling="auto" frameborder="0" src="${url}" style="width:100%;height:100%;"></iframe>`;
                $('#tt').tabs('add', {
                    title: title,
                    content: content,
                    closable: true,
                });
            }
        }
    </script>
</body>

</html>
