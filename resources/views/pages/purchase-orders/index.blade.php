<x-default-layout>
    <div id="dg"></div>
    <div id="tb">
        <x-button href="javascript:void(0)" iconCls="icon-add" plain="true" onclick="newPurchaseOrder()">Tambah</x-button>
        <x-button href="javascript:void(0)" iconCls="icon-edit" plain="true" onclick="editPurchaseOrder()">Edit</x-button>
        <x-button href="javascript:void(0)" iconCls="icon-remove" plain="true"
            onclick="destroyPurchaseOrder()">Hapus</x-button>
    </div>

    <div id="dlg" style="width:800px">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px">
            <div style="margin-bottom:10px">
                <x-text-box name="code" required="true" label="Kode Order:" labelPosition="top" style="width:100%" />
            </div>
            <div style="margin-bottom:10px">
                <x-date-box name="date" required="true" label="Tanggal:" labelPosition="top" style="width:100%" />
            </div>
            <div style="margin-bottom:10px">
                <x-text-box name="note" label="Catatan:" multiline="true" labelPosition="top"
                    style="width:100%;height:80px" />
            </div>
            <div style="margin-bottom:10px">
                <label style="display:block;margin-bottom:5px">Item Pembelian:</label>
                <div id="dg-items"></div>
                <div id="tb-items">
                    <x-button href="javascript:void(0)" iconCls="icon-add" plain="true" onclick="addItem()">Tambah
                        Item</x-button>
                    <x-button href="javascript:void(0)" iconCls="icon-remove" plain="true"
                        onclick="removeItem()">Hapus Item</x-button>
                </div>
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <x-button href="javascript:void(0)" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')"
            style="width:90px">Cancel</x-button>
        <x-button href="javascript:void(0)" class="c6" iconCls="icon-ok" onclick="savePurchaseOrder()"
            style="width:90px">Save</x-button>
    </div>

    <div id="dlg-item" style="width:400px">
        <form id="fm-item" method="post" novalidate style="margin:0;padding:20px">
            <div style="margin-bottom:10px">
                <input id="product_code" name="product_code" style="width:100%" />
                <input type="hidden" id="product_id" name="product_id" />
                <input type="hidden" id="product_name" name="product_name" />
            </div>
            <div style="margin-bottom:10px">
                <input id="warehouse_code" name="warehouse_code" style="width:100%" />
                <input type="hidden" id="warehouse_id" name="warehouse_id" />
                <input type="hidden" id="warehouse_name" name="warehouse_name" />
            </div>
            <div style="margin-bottom:10px">
                <x-text-box name="qty" id="qty" required="true" label="Jumlah:" labelPosition="top"
                    style="width:100%" />
            </div>
        </form>
    </div>
    <div id="dlg-item-buttons">
        <x-button href="javascript:void(0)" iconCls="icon-cancel" onclick="javascript:$('#dlg-item').dialog('close')"
            style="width:90px">Cancel</x-button>
        <x-button href="javascript:void(0)" class="c6" iconCls="icon-ok" onclick="saveItem()"
            style="width:90px">Save</x-button>
    </div>
</x-default-layout>

<x-window.product />
<x-window.warehouse />

<script>
    var itemsData = [];

    $("#dg").datagrid({
        url: "{{ route('api.v1.purchase-orders.index') }}",
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
                title: 'Kode Order',
                sortable: true,
                width: 100
            }, {
                field: 'date',
                title: 'Tanggal',
                sortable: true,
                width: 100
            }, {
                field: 'note',
                title: 'Catatan',
                width: 150
            }]
        ]
    })

    $("#dg-items").datagrid({
        toolbar: "#tb-items",
        rownumbers: true,
        fitColumns: true,
        singleSelect: true,
        columns: [
            [{
                field: 'product_name',
                title: 'Produk',
                width: 150
            }, {
                field: 'warehouse_name',
                title: 'Gudang',
                width: 100
            }, {
                field: 'qty',
                title: 'Jumlah',
                width: 80
            }]
        ],
        data: itemsData
    })

    $("#dlg").dialog({
        closed: true,
        modal: true,
        border: 'thin',
        buttons: "#dlg-buttons",
    })

    $("#dlg-item").dialog({
        closed: true,
        modal: true,
        border: 'thin',
        buttons: "#dlg-item-buttons",
    })

    var url;
    var method;
    var editItemIndex = -1;

    function newPurchaseOrder() {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Tambah Data Pembelian');
        $('#fm').form('clear');

        itemsData = [];
        $('#dg-items').datagrid('loadData', itemsData);

        url = "{{ route('api.v1.purchase-orders.store') }}";
        method = "POST";
    }

    function editPurchaseOrder() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Edit Data Pembelian');
            $('#fm').form('load', row);

            itemsData = row.purchase_order_items.map(item => ({
                product_id: item.product_id,
                product_code: item.product.code,
                product_name: item.product.name,
                warehouse_id: item.warehouse.id,
                warehouse_code: item.warehouse.code,
                warehouse_name: item.warehouse.name,
                qty: item.qty
            }));
            $('#dg-items').datagrid('loadData', itemsData);

            url = "{{ route('api.v1.purchase-orders.update', ':id') }}".replace(':id', row.id);
            method = "PUT";
        }
    }

    function addItem() {
        editItemIndex = -1;
        $('#dlg-item').dialog('open').dialog('center').dialog('setTitle', 'Tambah Item');
        $('#fm-item').form('clear');

        // Clear hidden fields
        $('#product_id').val('');
        $('#product_name').val('');
        $('#warehouse_id').val('');
        $('#warehouse_name').val('');
    }

    function removeItem() {
        var row = $('#dg-items').datagrid('getSelected');
        if (row) {
            var index = $('#dg-items').datagrid('getRowIndex', row);
            itemsData.splice(index, 1);
            $('#dg-items').datagrid('loadData', itemsData);
        }
    }

    function saveItem() {
        var productId = $('#product_id').val();
        var productCode = $('#product_code').textbox('getValue');
        var productName = $('#product_name').val();
        var warehouseId = $('#warehouse_id').val();
        var warehouseCode = $('#warehouse_code').textbox('getValue');
        var warehouseName = $('#warehouse_name').val();
        var qty = $('#qty').textbox('getValue');

        if (!productCode || !warehouseCode || !qty) {
            $.messager.alert('Error', 'Kode Produk, Kode Gudang atau Qty tidak boleh kosong!', 'error');
            return;
        }

        var newItem = {
            product_id: parseInt(productId),
            product_code: productCode,
            product_name: productName,
            warehouse_id: parseInt(warehouseId),
            warehouse_code: warehouseCode,
            warehouse_name: warehouseName,
            qty: parseInt(qty)
        };

        if (editItemIndex >= 0) {
            itemsData[editItemIndex] = newItem;
        } else {
            itemsData.push(newItem);
        }

        $('#dg-items').datagrid('loadData', itemsData);
        $('#dlg-item').dialog('close');
    }

    function savePurchaseOrder() {
        if (itemsData.length === 0) {
            $.messager.alert('Error', 'Minimal harus ada 1 item!', 'error');
            return;
        }

        var formData = new FormData($("#fm")[0]);
        var purchaseOrderData = Object.fromEntries(formData);

        purchaseOrderData.items = itemsData.map(item => ({
            product_id: item.product_id,
            warehouse_id: item.warehouse_id,
            qty: item.qty
        }));

        fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(purchaseOrderData),
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

    function destroyPurchaseOrder() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            $.messager.confirm('Konfirmasi', 'Apakah anda yakin? Data Data Pembelian akan dihapus!', function(r) {
                if (r) {
                    url = "{{ route('api.v1.purchase-orders.destroy', ':id') }}".replace(':id', row.id);

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

    $("#product_code").textbox({
        label: 'Kode Produk:',
        labelPosition: 'top',
        icons: [{
            iconCls: 'icon-search',
            handler: function(e) {
                $('#w-products').window('open');
            }
        }],
        onChange: function(newValue, oldValue) {
            if (newValue && newValue !== oldValue) {
                findProductByCode(newValue);
            }
        }
    });

    $("#warehouse_code").textbox({
        label: 'Kode Gudang:',
        labelPosition: 'top',
        icons: [{
            iconCls: 'icon-search',
            handler: function(e) {
                $('#w-warehouses').window('open');
            }
        }],
        onChange: function(newValue, oldValue) {
            if (newValue && newValue !== oldValue) {
                findWarehouseByCode(newValue);
            }
        }
    });

    $('#w-dg-products').datagrid({
        onClickRow: function(index, row) {
            $('#product_code').textbox('setValue', row.code);
            $('#product_id').val(row.id);
            $('#product_name').val(row.name);
            $('#w-products').window('close');
        }
    });

    $('#w-dg-warehouses').datagrid({
        onClickRow: function(index, row) {
            $('#warehouse_code').textbox('setValue', row.code);
            $('#warehouse_id').val(row.id);
            $('#warehouse_name').val(row.name);
            $('#w-warehouses').window('close');
        }
    });

    // Function to find product by code
    function findProductByCode(code) {
        fetch("{{ route('api.v1.products.index') }}?search=" + code + "&limit=1000")
            .then(response => response.json())
            .then(result => {
                if (result.rows && result.rows.length > 0) {
                    const product = result.rows.find(p => p.code.toLowerCase() === code.toLowerCase());
                    if (product) {
                        $('#product_id').val(product.id);
                        $('#product_name').val(product.name);
                    } else {
                        $('#product_id').val('');
                        $('#product_name').val('');
                        $.messager.alert('Warning', 'Kode Produk "' + code + '" tidak ditemukan!', 'warning');
                        $('#product_code').textbox('setValue', '');
                    }
                } else {
                    $('#product_id').val('');
                    $('#product_name').val('');
                    $.messager.alert('Warning', 'Kode Produk "' + code + '" tidak ditemukan!', 'warning');
                    $('#product_code').textbox('setValue', '');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                $.messager.alert('Error', 'Terjadi kesalahan saat mencari produk!', 'error');
            });
    }

    // Function to find warehouse by code
    function findWarehouseByCode(code) {
        fetch("{{ route('api.v1.warehouses.index') }}?search=" + code + "&limit=1000")
            .then(response => response.json())
            .then(result => {
                if (result.rows && result.rows.length > 0) {
                    const warehouse = result.rows.find(w => w.code.toLowerCase() === code.toLowerCase());
                    if (warehouse) {
                        $('#warehouse_id').val(warehouse.id);
                        $('#warehouse_name').val(warehouse.name);
                    } else {
                        $('#warehouse_id').val('');
                        $('#warehouse_name').val('');
                        $.messager.alert('Warning', 'Kode Gudang "' + code + '" tidak ditemukan!', 'warning');
                        $('#warehouse_code').textbox('setValue', '');
                    }
                } else {
                    $('#warehouse_id').val('');
                    $('#warehouse_name').val('');
                    $.messager.alert('Warning', 'Kode Gudang "' + code + '" tidak ditemukan!', 'warning');
                    $('#warehouse_code').textbox('setValue', '');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                $.messager.alert('Error', 'Terjadi kesalahan saat mencari gudang!', 'error');
            });
    }
</script>
