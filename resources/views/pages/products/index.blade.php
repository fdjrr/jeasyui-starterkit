<x-default-layout>
    <div id="dg"></div>

    <div id="tb">
        <x-button href="javascript:void(0)" iconCls="icon-add" plain="true" onclick="newProduct()">New
            Product</x-button>
        <x-button href="javascript:void(0)" iconCls="icon-edit" plain="true" onclick="editProduct()">Edit
            Product</x-button>
        <x-button href="javascript:void(0)" iconCls="icon-remove" plain="true" onclick="destroyProduct()">Remove
            Product</x-button>
    </div>

    <div id="dlg" style="width:400px">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px">
            <div style="margin-bottom:10px">
                <x-text-box name="name" required="true" label="Name:" labelPosition="top" style="width:100%" />
            </div>
            <div style="margin-bottom:10px">
                <x-text-box name="email" required="true" validType="email" label="Email:" labelPosition="top"
                    style="width:100%" />
            </div>
            <div style="margin-bottom:10px">
                <x-text-box type="password" name="password" required="true" label="Password:" labelPosition="top"
                    style="width:100%" />
            </div>
            <div style="margin-bottom:10px">
                <x-text-box type="password" name="confirm_password" required="true" label="Confirm Password:"
                    labelPosition="top" style="width:100%" />
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <x-button href="javascript:void(0)" iconCls="icon-cancel" onclick="closeDlgProduct()"
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
                field: 'category',
                title: 'Kategori Produk',
                sortable: true,
                width: 100
            }, {
                field: 'unit',
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
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'New Product');
        $('#fm').form('clear');
        url = "{{ route('api.v1.products.store') }}";
        method = "POST";
    }

    function editProduct() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Edit Product');
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
            $.messager.confirm('Confirm', 'Are you sure you want to destroy this product?', function(r) {
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
