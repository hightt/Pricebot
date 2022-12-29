@extends('index')
@section('content')
<script type="text/javascript" src="{{ asset('libraries/chart.js') }}"></script>
<div class="alert alert-info" role="alert">
    Produkt wyświetlany w tej sekcji musi spełniać następujące kryteria:
    <ul>
        <li>Produkt musi być na promocji.</li>
        <li>Promocja musi uwzględniać zniżkę wielkości minimum 5%.</li>
        <li>Zaszła zmiana w cenie produktu w ciągu ostatnich 30 dni (wykluczenie <span class="text-danger fw-bold">fake'owych promocji</span>).</li>
        <li>Produkt musi mieć podaną starą cenę, produkty mające promocję bez starej ceny nie są uwzględniane.</li>
    </ul>
</div>
<div id="root" class="container">

    @if(count($products) > 1)
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Produkt</th>
                <th>Zniżka cenowa</th>
                <th>Procent zniżki</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td><a class="product_name" href="{{ route('products.show', $product->id) }}">{{$product->name}}</a></td>
                <td>{{sprintf("%.2f zł", $product->discount['price'])}}</td>
                <td>{{sprintf("%.2f %%", $product->discount['percentage'])}}</td>
            </tr>
            @endforeach

        </tbody>
    </table>
    @else
    <h4 class="text-center">Brak produktów na promociji</h4>
    @endif


    <div class="d-flex justify-content-center">
        {{$products->links()}}
    </div>
</div>


@endsection