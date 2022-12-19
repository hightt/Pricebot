@extends('index')
@section('content')
<script type="text/javascript" src="{{ asset('libraries/chart.js') }}"></script>
<div class="alert alert-info" role="alert">
    Produkt wyświetlany w tej sekcji musi spełniać następujące kryteria:
    <ul>
        <li>Produkt musi być na promocji.</li>
        <li>Promocja musi uwzględniać zniżkę wielkości minimum 20%.</li>
        <li>Zaszła zmiana w cenie produktu w ciągu ostatnich 30 dni (wykluczenie fake'owych promocji).</li>
        <li>Produkt musi mieć podaną starą cenę, produkty mające promocję bez starej ceny nie są uwzględniane.</li>
    </ul>
</div>
<div id="root" class="container">

    @if(count($products) > 1)
    @foreach ($products as $product)
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Produkt</th>
                <th>Zniżka cenowa</th>
                <th>Procent zniżki</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><a class="product_name" href="{{ route('products.show', $product->id) }}">{{$product->name}}</a></td>
                <td>{{sprintf("%.2f zł", $product->discount['price'])}}</td>
                <td>{{sprintf("%.2f %%", $product->discount['percentage'])}}</td>
            </tr>
        </tbody>
    </table>
    @endforeach
    @else
    <h4 class="text-center">Brak produktów na promociji</h4>
    @endif


    <div class="d-flex justify-content-center">
        {{$products->links()}}
    </div>
</div>


@endsection