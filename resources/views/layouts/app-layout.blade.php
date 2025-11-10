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
                <div title="Dashboard" data-options="selected:true" style="padding:10px;">
                </div>
                <div title="Transaksi" data-options="selected:false" style="padding:10px;">
                    <ul id="transactionTree" class="easyui-tree">
                        <li data-id="sales-order">Data Penjualan</li>
                        <li data-id="purchase-order">Data Pembelian</li>
                    </ul>
                </div>
                <div title="Master Data" data-options="selected:false" style="padding:10px;">
                    <ul id="masterTree" class="easyui-tree">
                        <li data-id="warehouse">Data Gudang</li>
                        <li data-id="product">Data Produk</li>
                        <li data-id="product-category">Data Kategori Produk</li>
                        <li data-id="product-unit">Data Unit Produk</li>
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
                    case 'Data Penjualan':
                        addTab('Transaksi > Data Penjualan', "{{ route('sales_orders.index') }}");
                        break;

                    case 'Data Pembelian':
                        addTab('Transaksi > Data Pembelian', "{{ route('purchase_orders.index') }}");
                        break;
                }
            }
        });

        $('#masterTree').tree({
            onClick: function(node) {
                switch (node.text) {
                    case 'Data Gudang':
                        addTab('Master Data > Data Gudang', "{{ route('warehouses.index') }}");
                        break;

                    case 'Data Produk':
                        addTab('Master Data > Data Produk', "{{ route('products.index') }}");
                        break;

                    case 'Data Kategori Produk':
                        addTab('Master Data > Data Kategori Produk',
                            "{{ route('product_categories.index') }}");
                        break;

                    case 'Data Unit Produk':
                        addTab('Master Data > Data Unit Produk', "{{ route('product_units.index') }}");
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
