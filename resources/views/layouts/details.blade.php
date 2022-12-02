@extends('index')


@section('content')
<script type="text/javascript" src="{{ asset('libraries/chart.js') }}"></script>
<script src="{{asset('js/chartScript.js')}}"></script>
<div class="col-lg-12 pt-4 pb-4">
    <div class="row text-left ms-5">
        <a href="{{route('products.index')}}">
            <i class="fa-solid fa-left-long arrow-close" style="font-size: 35px;"></i>
        </a>
    </div>
    <div class="row">
        <h5 class="text-center">{{$product->name}}</h5>
    </div>
    <div>
        <canvas id="myChart"></canvas>
    </div>

    <div class="row mt-3">
        <a class="h4 text-dark text-decoration-none " data-bs-toggle="collapse" href="#details" role="button" aria-expanded="false" aria-controls="details">
            Informacje o produkcie
        </a>
        <div class="collapse show" id="details">
            <div class="card card-body">
                <div class="row">
                    <div class="col-lg-4 fw-bold">
                        Identyfikator:
                    </div>
                    <div class="col-lg-8">
                        {{$product->id}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 fw-bold">
                        Nazwa:
                    </div>
                    <div class="col-lg-8">
                        {{$product->name}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 fw-bold">
                        @if($product->promotion == 1)
                        Obecna cena promocyjna:
                        @else
                        Obecna cena:
                        @endif
                    </div>
                    <div class="col-lg-8">
                        {{$product->current_price . " zł"}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 fw-bold">
                        Promocja:
                    </div>
                    <div class="col-lg-8">
                        @if($product->promotion == 1)
                        <i style="color: green;">✓</i>
                        @else
                        <i style="color: red;">✕</i>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 fw-bold">
                        Przeceniono z kwoty:
                    </div>
                    <div class="col-lg-8">
                        @if($product->promotion == 1)
                        {{$product->old_price . " zł"}}
                        @else
                        <i style="color: red;">✕</i>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 fw-bold">
                        Zniżka:
                    </div>
                    <div class="col-lg-8 ">
                        @if($product->promotion == 1)
                        {{number_format($product->old_price - $product->current_price, 2, '.', '') . " zł"}}
                        @else
                        <i style="color: red;">✕</i>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <a class="h4 text-dark text-decoration-none " data-bs-toggle="collapse" href="#details_refresh" role="button" aria-expanded="false" aria-controls="details_refresh">
            Szczegóły
        </a>
        <div class="collapse show" id="details_refresh">
            <div class="card card-body">
                <div class="row">
                    <div class="col-lg-4 fw-bold">
                        Ostatnia aktualizacja:
                    </div>
                    <div class="col-lg-8">
                        {{$product->updated_at_formatted}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 fw-bold">
                        URL:
                    </div>
                    <div class="col-lg-8">
                        <a href="{{$product->url}}">{{$product->name}}</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var productId = "{{$product->id}}";
        console.log(productId);

        function getProduct() {
            $.ajax({
                url: "/getProductsAjax/" + productId,
                success: function(response) {
                    // console.log(response);
                    drawChart(response);
                },
                error: function(response) {
                    console.log(response);
                }

            });
        }
        
        function drawChart(product) {

            const data = {
                labels: product.axis_data.oyAxis,
                datasets: [{
                    label: "Cena: ",
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: product.axis_data.oxAxis,
                }]
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    plugins: {
                        legend: {
                            display: false,
                            position: 'bottom',
                            labels: {
                                color: 'black',

                            },
                        },
                        title: {
                            display: true,
                            text: 'Rys 1. Zmiana ceny produktu w podanym okresie czasu',
                            position: 'bottom'

                        }
                    },
                    scales: {
                        y: {
                            title: {
                                display: true,
                                text: "Kwota (zł)"
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: "Data (dzień - miesiąc - rok)"
                            }
                        }
                    }
                }
            };



            const myChart = new Chart(
                document.getElementById("myChart"),

                config
            );
        }


        getProduct();
    });
</script>

@endsection