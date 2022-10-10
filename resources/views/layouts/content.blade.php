<div class="col-lg-12 pt-4 pb-4">
    <table id="mainTable" class="table table-striped table-hover" >
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
            responsive: true,
            processing: true,
            serverSide: true,

            ajax: {
                url: "{{route('products.ajax')}}",
                'headers': {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            },
            columns: [
                {
                    data: 'external_id',
                    responsivePriority: 1
                },
                {
                    data: 'name',
                    responsivePriority: 5
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
            pageLength: 20,
            language: {
                searchPlaceholder: "Wyszukaj produkty",
                search: "",
                paginate: {
                    'previous': '<i class="fa-solid fa-chevron-left"></i>',
                    'next': '<i class="fa-solid fa-chevron-right"></i>'
                }
            },

        });

    });
</script>
