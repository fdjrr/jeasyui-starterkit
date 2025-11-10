<x-default-layout>
    <div id="dg"></div>
    <div id="tb">
        <x-button href="javascript:void(0)" iconCls="icon-add" plain="true"
            onclick="newProductCategory()">Tambah</x-button>
        <x-button href="javascript:void(0)" iconCls="icon-edit" plain="true"
            onclick="editProductCategory()">Edit</x-button>
        <x-button href="javascript:void(0)" iconCls="icon-remove" plain="true"
            onclick="destroyProductCategory()">Hapus</x-button>
    </div>

    <div id="dlg" style="width:400px">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px">
            <div style="margin-bottom:10px">
                <x-text-box name="code" required="true" label="Kode Kategori:" labelPosition="top"
                    style="width:100%" />
            </div>
            <div style="margin-bottom:10px">
                <x-text-box name="name" required="true" label="Nama Kategori:" labelPosition="top"
                    style="width:100%" />
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <x-button href="javascript:void(0)" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')"
            style="width:90px">Cancel</x-button>
        <x-button href="javascript:void(0)" class="c6" iconCls="icon-ok" onclick="saveProductCategory()"
            style="width:90px">Save</x-button>
    </div>
</x-default-layout>

<script>
    $("#dg").datagrid({
        url: "{{ route('api.v1.product_categories.index') }}",
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
                title: 'Kode Kategori',
                sortable: true,
                width: 100
            }, {
                field: 'name',
                title: 'Nama Kategori',
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

    function newProductCategory() {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Tambah Kategori');
        $('#fm').form('clear');
        url = "{{ route('api.v1.product_categories.store') }}";
        method = "POST";
    }

    function editProductCategory() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Edit Kategori');
            $('#fm').form('load', row);
            url = "{{ route('api.v1.product_categories.update', ':id') }}".replace(':id', row.id);
            method = "PUT";
        }
    }

    function saveProductCategory() {
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

    function destroyProductCategory() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            $.messager.confirm('Konfirmasi', 'Apakah anda yakin? Data Kategori akan dihapus!', function(r) {
                if (r) {
                    url = "{{ route('api.v1.product_categories.destroy', ':id') }}".replace(':id', row.id);

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
