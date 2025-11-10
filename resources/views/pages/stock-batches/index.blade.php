<x-default-layout>
    <div id="dg"></div>
    <div id="tb">
        <x-button href="javascript:void(0)" iconCls="icon-add" plain="true" onclick="newStockBatch()">Tambah</x-button>
        <x-button href="javascript:void(0)" iconCls="icon-edit" plain="true" onclick="editStockBatch()">Edit</x-button>
        <x-button href="javascript:void(0)" iconCls="icon-remove" plain="true"
            onclick="destroyStockBatch()">Hapus</x-button>
    </div>

    <div id="dlg" style="width:500px">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px">
            <div style="margin-bottom:10px">
                <x-text-box name="batch_code" required="true" label="Kode Stok:" labelPosition="top"
                    style="width:100%" />
            </div>
            <div style="margin-bottom:10px">
                <input name="product_code" id="product_code" style="width:100%" />
            </div>
            <div style="margin-bottom:10px">
                <input name="warehouse_code" id="warehouse_code" style="width:100%" />
            </div>
            <div style="margin-bottom:10px">
                <x-text-box name="qty_in" required="true" label="Qty Masuk:" labelPosition="top" style="width:100%" />
            </div>
            <div style="margin-bottom:10px">
                <x-text-box name="qty_out" required="true" label="Qty Keluar:" labelPosition="top" style="width:100%" />
            </div>
            <div style="margin-bottom:10px">
                <x-number-box name="purchase_price" required="true" precision="2" groupSeparator="."
                    decimalSeparator="," label="Harga Beli:" labelPosition="top" style="width:100%" />
            </div>
            <div style="margin-bottom:10px">
                <x-date-box name="received_at" id="received_at" required="true" label="Tanggal Terima:"
                    labelPosition="top" style="width:100%" />
            </div>
            <div style="margin-bottom:10px">
                <x-date-box name="expired_at" id="expired_at" label="Tanggal Kadaluarsa:" labelPosition="top"
                    style="width:100%" />
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <x-button href="javascript:void(0)" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')"
            style="width:90px">Cancel</x-button>
        <x-button href="javascript:void(0)" class="c6" iconCls="icon-ok" onclick="saveStockBatch()"
            style="width:90px">Save</x-button>
    </div>
</x-default-layout>

<x-window.product />
<x-window.warehouse />

<script>
    $("#dg").datagrid({
        url: "{{ route('api.v1.stock_batches.index') }}",
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
                    field: "batch_code",
                    title: "Kode Stok",
                    sortable: true,
                    width: 100,
                }, {
                    field: "product",
                    title: "Produk",
                    sortable: true,
                    width: 100,
                },
                {
                    field: "warehouse",
                    title: "Gudang",
                    sortable: true,
                    width: 100,
                },
                {
                    field: "qty_in",
                    title: "Qty Masuk",
                    sortable: true,
                    width: 100,
                },
                {
                    field: "qty_out",
                    title: "Qty Keluar",
                    sortable: true,
                    width: 100,
                },
                {
                    field: "purchase_price_formatted",
                    title: "Harga Beli",
                    sortable: true,
                    width: 100,
                },
                {
                    field: "received_at",
                    title: "Tanggal Terima",
                    sortable: true,
                    width: 100,
                },
                {
                    field: "expired_at",
                    title: "Tanggal Kadaluarsa",
                    sortable: true,
                    width: 100,
                },
            ],
        ],
    });

    $("#dlg").dialog({
        closed: true,
        modal: true,
        border: "thin",
        buttons: "#dlg-buttons",
    });

    $("#product_code").textbox({
        required: true,
        label: "Kode Produk:",
        labelPosition: "top",
        icons: [{
            iconCls: 'icon-search',
            handler: function(e) {
                $('#w-products').data('targetField', '#product_code').window('open')
            }
        }]
    });

    $("#warehouse_code").textbox({
        required: true,
        label: "Kode Gudang:",
        labelPosition: "top",
        icons: [{
            iconCls: 'icon-search',
            handler: function(e) {
                $('#w-warehouses').data('targetField', '#warehouse_code').window('open')
            }
        }]
    });

    var url;
    var method;

    function newStockBatch() {
        $("#dlg").dialog("open").dialog("center").dialog("setTitle", "Tambah Stok");
        $("#fm").form("clear");
        url = "{{ route('api.v1.stock_batches.store') }}";
        method = "POST";
    }

    function editStockBatch() {
        var row = $("#dg").datagrid("getSelected");
        if (row) {
            $("#dlg")
                .dialog("open")
                .dialog("center")
                .dialog("setTitle", "Edit Stok");
            $("#fm").form("load", row);
            url = "{{ route('api.v1.stock_batches.update', ':id') }}".replace(
                ":id",
                row.id,
            );
            method = "PUT";
        }
    }

    function saveStockBatch() {
        var formData = new FormData($("#fm")[0]);
        var data = Object.fromEntries(formData);

        if (data.purchase_price) {
            data.purchase_price = Number(data.purchase_price)
        }

        if (data.received_at) {
            const date = new Date(data.received_at);
            data.received_at = `${date.getFullYear()}-${date.getMonth()}-${date.getDate()}`
        }

        if (data.expired_at) {
            const date = new Date(data.expired_at);
            data.expired_at = `${date.getFullYear()}-${date.getMonth()}-${date.getDate()}`
        }

        fetch(url, {
                method: method,
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify(data),
            })
            .then((response) => response.json())
            .then((result) => {
                if (result.success) {
                    $("#dlg").dialog("close");
                    $("#dg").datagrid("reload");
                } else {
                    $.messager.show({
                        title: "Error",
                        msg: result.message,
                    });
                }
            });
    }

    function destroyStockBatch() {
        var row = $("#dg").datagrid("getSelected");
        if (row) {
            $.messager.confirm(
                "Konfirmasi",
                "Apakah anda yakin? Data Produk akan dihapus!",
                function(r) {
                    if (r) {
                        url =
                            "{{ route('api.v1.stock_batches.destroy', ':id') }}".replace(
                                ":id",
                                row.id,
                            );

                        fetch(url, {
                                method: "DELETE",
                            })
                            .then((response) => response.json())
                            .then((result) => {
                                if (result.success) {
                                    $("#dg").datagrid("reload");
                                } else {
                                    $.messager.show({
                                        title: "Error",
                                        msg: result.message,
                                    });
                                }
                            });
                    }
                },
            );
        }
    }
</script>
