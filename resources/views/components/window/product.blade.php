<div id="w-products" class="easyui-window" style="width:750px;height:600px;padding:10px;">
    <div id="w-dg-products"></div>
</div>

<div id="w-tb-products" style="padding:2px 5px;">
    Cari Produk: <x-text-box id="w-search-products" style="width:200px" />
    Kategori Produk:
    <select class="easyui-combobox" id="w-product-category-id-products" panelHeight="auto" style="width:100px">
        <option value="">Pilih Kategori Produk</option>
        @forelse ($product_categories as $product_category)
            <option value="{{ $product_category->id }}">{{ $product_category->name }}</option>
        @empty
        @endforelse
    </select>
    <x-button href="#" id="w-btnSearch-products" iconCls="icon-search">Cari</x-button>
</div>

<script>
    $("#w-products").window({
        title: "Data Produk",
        modal: true,
        closed: true,
        rownumbers: true,
        singleSelect: true,
    });

    $("#w-dg-products").datagrid({
        url: "{{ route('api.v1.products.index') }}",
        method: "get",
        toolbar: $("#w-tb-products"),
        pagination: true,
        rownumbers: true,
        fitColumns: true,
        fit: true,
        singleSelect: true,
        remoteSort: false,
        remoteFilter: true,
        columns: [
            [{
                    field: "code",
                    title: "Kode Produk",
                    sortable: true,
                    width: 100,
                },
                {
                    field: "name",
                    title: "Nama Produk",
                    sortable: true,
                    width: 100,
                },
                {
                    field: "sku",
                    title: "SKU",
                    sortable: true,
                    width: 100,
                },
                {
                    field: "product_category",
                    title: "Kategori Produk",
                    sortable: true,
                    width: 100,
                },
            ],
        ],
        onClickRow: function(index, row) {
            const target = $('#w-products').data('targetField');

            if (target) {
                $(target).textbox('setValue', row.code);
            }

            $("#w-products").window("close");
        },
    });

    $("#w-btnSearch-products").click(function() {
        const search = $("#w-search-products").textbox("getValue");
        const product_category_id = $("#w-product-category-id-products").combobox(
            "getValue",
        );

        $("#w-dg-products").datagrid("load", {
            search,
            product_category_id,
        });
    });
</script>
