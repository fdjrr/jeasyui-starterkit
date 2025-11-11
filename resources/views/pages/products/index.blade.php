<x-default-layout>
    <div id="dg"></div>
    <div id="tb">
        <x-button href="javascript:void(0)" iconCls="icon-add" plain="true" onclick="newProduct()">Tambah</x-button>
        <x-button href="javascript:void(0)" iconCls="icon-edit" plain="true" onclick="editProduct()">Edit</x-button>
        <x-button href="javascript:void(0)" iconCls="icon-search" plain="true" onclick="showProductStock()">Lihat
            Stock</x-button>
        <x-button href="javascript:void(0)" iconCls="icon-remove" plain="true"
            onclick="destroyProduct()">Hapus</x-button>
    </div>

    <div id="dlg" style="width:500px">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px">
            <div style="margin-bottom:10px">
                <x-text-box name="code" required="true" label="Kode Produk:" labelPosition="top"
                    style="width:100%" />
            </div>
            <div style="margin-bottom:10px">
                <x-text-box name="name" required="true" label="Nama Produk:" labelPosition="top"
                    style="width:100%" />
            </div>
            <div style="margin-bottom:10px">
                <x-text-box name="sku" required="true" label="SKU:" labelPosition="top" style="width:100%" />
            </div>
            <div style="margin-bottom:10px">
                <select class="easyui-combobox" name="product_category_id" required="true" label="Kategori Produk:"
                    labelPosition="top" style="width:100%;">
                    @forelse ($product_categories as $product_category)
                        <option value="{{ $product_category->id }}">{{ $product_category->name }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div style="margin-bottom:10px">
                <select class="easyui-combobox" name="product_unit_id" required="true" label="Unit:"
                    labelPosition="top" style="width:100%;">
                    @forelse ($product_units as $product_unit)
                        <option value="{{ $product_unit->id }}">{{ $product_unit->name }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div style="margin-bottom:10px">
                <x-text-box name="description" label="Keterangan:" multiline="true" labelPosition="top"
                    style="width:100%;height:100px" />
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <x-button href="javascript:void(0)" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')"
            style="width:90px">Cancel</x-button>
        <x-button href="javascript:void(0)" class="c6" iconCls="icon-ok" onclick="saveProduct()"
            style="width:90px">Save</x-button>
    </div>
</x-default-layout>

<script>
    $("#dg").datagrid({
        url: "{{ route('api.v1.products.index') }}",
        method: "get",
        toolbar: "#tb",
        pagination: true,
        rownumbers: true,
        fitColumns: true,
        fit: true,
        singleSelect: true,
        remoteSort: false,
        multiSort: true,
        columns: [
            [{
                field: 'code',
                title: 'Kode Produk',
                sortable: true,
                width: 100
            }, {
                field: 'name',
                title: 'Nama Produk',
                sortable: true,
                width: 100
            }, {
                field: 'sku',
                title: 'SKU',
                sortable: true,
                width: 100
            }, {
                field: 'product_category',
                title: 'Kategori Produk',
                sortable: true,
                width: 100
            }, {
                field: 'product_unit',
                title: 'Unit',
                sortable: true,
                width: 100
            }]
        ]
    })

    $("#dlg").dialog({
        closed: true,
        modal: true,
        border: 'thin',
        buttons: "#dlg-buttons",
    })

    var url;
    var method;

    function newProduct() {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Tambah Produk');
        $('#fm').form('clear');
        url = "{{ route('api.v1.products.store') }}";
        method = "POST";
    }

    function editProduct() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Edit Produk');
            $('#fm').form('load', row);
            url = "{{ route('api.v1.products.update', ':id') }}".replace(':id', row.id);
            method = "PUT";
        }
    }

    function saveProduct() {
        var formData = new FormData($("#fm")[0]);

        fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(Object.fromEntries(formData)),
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    $('#dlg').dialog('close');
                    $('#dg').datagrid('reload');
                } else {
                    $.messager.show({
                        title: 'Error',
                        msg: result.message
                    });
                }
            });
    }

    function destroyProduct() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            $.messager.confirm('Konfirmasi', 'Apakah anda yakin? Data Produk akan dihapus!', function(r) {
                if (r) {
                    url = "{{ route('api.v1.products.destroy', ':id') }}".replace(':id', row.id);

                    fetch(url, {
                            method: 'DELETE'
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.success) {
                                $('#dg').datagrid('reload');
                            } else {
                                $.messager.show({
                                    title: 'Error',
                                    msg: result.message
                                });
                            }
                        });
                }
            });
        }
    }
</script>
