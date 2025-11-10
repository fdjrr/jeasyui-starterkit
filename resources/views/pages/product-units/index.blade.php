<x-default-layout>
    <div id="dg"></div>
    <div id="tb">
        <x-button href="javascript:void(0)" iconCls="icon-add" plain="true" onclick="newProductUnit()">Tambah</x-button>
        <x-button href="javascript:void(0)" iconCls="icon-edit" plain="true" onclick="editProductUnit()">Edit</x-button>
        <x-button href="javascript:void(0)" iconCls="icon-remove" plain="true"
            onclick="destroyProductUnit()">Hapus</x-button>
    </div>

    <div id="dlg" style="width:400px">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px">
            <div style="margin-bottom:10px">
                <x-text-box name="code" required="true" label="Kode Unit:" labelPosition="top" style="width:100%" />
            </div>
            <div style="margin-bottom:10px">
                <x-text-box name="name" required="true" label="Nama Unit:" labelPosition="top" style="width:100%" />
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <x-button href="javascript:void(0)" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')"
            style="width:90px">Cancel</x-button>
        <x-button href="javascript:void(0)" class="c6" iconCls="icon-ok" onclick="saveProductUnit()"
            style="width:90px">Save</x-button>
    </div>
</x-default-layout>

<script>
    $("#dg").datagrid({
        url: "{{ route('api.v1.product_units.index') }}",
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
                title: 'Kode Unit',
                sortable: true,
                width: 100
            }, {
                field: 'name',
                title: 'Nama Unit',
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

    function newProductUnit() {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Tambah Unit');
        $('#fm').form('clear');
        url = "{{ route('api.v1.product_units.store') }}";
        method = "POST";
    }

    function editProductUnit() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Edit Unit ');
            $('#fm').form('load', row);
            url = "{{ route('api.v1.product_units.update', ':id') }}".replace(':id', row.id);
            method = "PUT";
        }
    }

    function saveProductUnit() {
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

    function destroyProductUnit() {
        var row = $('#dg').datagrid('getSelected');
        if (row) {
            $.messager.confirm('Konfirmasi', 'Apakah anda yakin? Data Unit akan dihapus!', function(r) {
                if (r) {
                    url = "{{ route('api.v1.product_units.destroy', ':id') }}".replace(':id', row.id);

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
