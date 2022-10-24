@extends('index')


@section('content')
<div class="col-lg-12 pt-4 pb-4 ps-0 pe-0">
    <table id="mainTable" class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Produkt</th>
                <th scope="col">Obecna cena (zł)</th>
                <th scope="col">Promocja</th>
                <th scope="col">Przeceniony (zł)</th>
            </tr>
        </thead>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#mainTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{route('products.ajax')}}",
                'headers': {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            },
            columns: [{
                    data: 'external_id',
                    responsivePriority: 1
                },
                {
                    data: 'name',
                    responsivePriority: 5,
                    render: function(data, type, row) {
                        var name = data;
                        if (parseInt(data.length) > 95)
                            name = data.substring(0, 95) + "...";
                        return "<a class='product-name text-decoration-none' href='/products/" + row.id + "' " + "title='" + data + "'" + ">" + "<span class='product_name'>" + name + "</span>" + "</a>";
                    }
                },
                {
                    data: 'current_price',
                    responsivePriority: 2
                },
                {
                    data: 'promotion',
                    responsivePriority: 3
                },
                {
                    data: 'old_price',
                    responsivePriority: 4
                },
            ],
            paging: true,
            order: [
                [4, 'desc']
            ],
            info: false,
            lengthChange: false,
            pageLength: 15,
            searching: true,
            language: {
                searchPlaceholder: "Wyszukaj produkty",
                search: "",
                paginate: {
                    'previous': '<i class="fa-solid fa-chevron-left"></i>',
                    'next': '<i class="fa-solid fa-chevron-right"></i>'
                },
            },
            "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>'
            // "dom": 'rtp'

        });
    });
</script>
@endsection