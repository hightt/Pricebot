@extends('index')


@section('content')
<script type="text/javascript" src="{{ asset('libraries/chart.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>

<div class="col-lg-12 pt-4 pb-4">
    <div class="row">
        <h5 class="text-center" >{{$product->name}}</h5>
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
    var product = <?php echo json_encode($product); ?>

    $(document).ready(function() {
        $.ajax({
            url: "{{route('details.ajax', $product->id)}}",
            cache: false,
            success: function(response) {
                chart(response);
            }
        });

        function chart(response) {
            console.log(response);
            const labels = response.labels;

            const data = {
                labels: labels,
                datasets: [{
                    label: "Cena: ",
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: response.prices,
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
                }
            };



            const myChart = new Chart(
                document.getElementById('myChart'),

                config
            );
        }

    });
</script>

@endsection
