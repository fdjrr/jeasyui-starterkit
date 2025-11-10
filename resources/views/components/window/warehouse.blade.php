<div id="w-warehouses" class="easyui-window" style="width:750px;height:600px;padding:10px;">
    <div id="w-dg-warehouses"></div>
</div>

<div id="w-tb-warehouses" style="padding:2px 5px;">
    Cari Gudang: <x-text-box id="w-search-warehouses" style="width:200px" />
    <x-button href="#" id="w-btnSearch-warehouses" iconCls="icon-search">Cari</x-button>
</div>

<script>
    $("#w-warehouses").window({
        title: "Data Gudang",
        modal: true,
        closed: true,
        rownumbers: true,
        singleSelect: true,
    });

    $("#w-dg-warehouses").datagrid({
        url: "{{ route('api.v1.warehouses.index') }}",
        method: "get",
        toolbar: $("#w-tb-warehouses"),
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
                    title: "Kode Gudang",
                    sortable: true,
                    width: 100,
                },
                {
                    field: "name",
                    title: "Nama Gudang",
                    sortable: true,
                    width: 100,
                },
                {
                    field: "address",
                    title: "Alamat",
                    sortable: true,
                    width: 100,
                },
            ],
        ],
        onClickRow: function(index, row) {
            const target = $('#w-warehouses').data('targetField');

            if (target) {
                $(target).textbox('setValue', row.code);
            }

            $("#w-warehouses").window("close");
        },
    });

    $("#w-btnSearch-warehouses").click(function() {
        const search = $("#w-search-warehouses").textbox("getValue");

        $("#w-dg-warehouses").datagrid("load", {
            search,
        });
    });
</script>
