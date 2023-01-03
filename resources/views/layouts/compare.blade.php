@extends('index')
@section('content')
<script type="text/javascript" src="{{ asset('libraries/chart.js') }}"></script>
<div class="col-lg-12 m-0">
    <div class="row">
        <h4>Wybrane produkty do porównania</h4>
        @if(count($products) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th colspan="2" scope="col">Produkt</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td><a class="text-dark fw-bold" href="{{ route('products.show', $product->id) }}">{{$product->name}}</a></td>
                    <td class="removeProduct" productId={{ $product->id }}>
                        <form action="{{ route('compare.remove', $product->id) }}" method="GET">
                            <button class="border-0" type="submit">
                                <i class="fa-solid fa-trash text-danger" style="cursor: pointer;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="m-0 p-0">
            <canvas class="m-0 p-0" id="productsChart"></canvas>
        </div>
        @else
        <div class="text-center">
        <i class="d-block fa-solid fa-circle-exclamation" style="font-size: 125px;"></i>
            <h5 class="mt-2">
                Brak danych. Dodaj produkt do porównania ceny w jego szczegółach za pomocą przycisku
                <i class="fa-solid fa-plus"></i>
            </h5>
        </div>
        @endif
    </div>
</div>

<script>
    $(document).ready(function() {

        function getProductsFromSession() {
            $.ajax({
                method: "GET",
                url: "{{ route('compare.get') }}",
                success: function(response) {
                    console.log(response);
                    drawChart(response);
                },
            })
        }

        function drawChart(products) {
            var ctx = document.getElementById("productsChart");

            var productsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: []
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: 'black',
                                align: 'start'
                            },
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: "Kwota"
                            },
                            ticks: {
                                    callback: function(value, index, ticks) {
                                    return value + " zł";
                                }
                            }
                        },
                        x: {
                        }
                    }
                }
            });

            function addData(chart, name, color, data) {
                chart.data.datasets.push({
                    label: name,
                    backgroundColor: color,
                    borderColor: color,
                    data: data,
                });
                chart.update();
            }

            let colorPalette = ["#2A3990", "#D3C0CD", "#B19994", "#937666", "#3D3A4B", "#9C254D"];
            $.each(products, function(index, value) {
                addData(productsChart, value.name, colorPalette[index], value.axis_data.common);
            });
        }

        getProductsFromSession();

        $('tbody').on('click', '.removeProduct', function() {
            var productId = $(this).attr('productId');
            $.ajax({
                method: "GET",
                async: false,
                url: "/removeProductFromSession/" + productId,
                success: function(response) {

                },
            })
        });
    });
</script>
@endsection