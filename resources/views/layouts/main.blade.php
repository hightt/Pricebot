@extends('index')


@section('content')
<div class="row" style="min-height: 75vh;">
    <div class="col-lg-6 mt-lg-5">
        <div class="col-lg-12">
            <h2>Monitoring cen hurtowni <span class="text-warning">Dolina Noteci*</span></h2>
            <h5 style="text-align: justify;">
                Pricebot tworzy historię cen produktów, a także dokonuje analizy wiarygodności promocji produktów wyświetlanych w hurtowni. Dane przedstawione są na interaktywnych wykresach umożliwiających szybkie i przyjemne pozyskiwanie informacji.
            </h5>
            <ul class="fa-ul">
                <li>
                    <span class="fa-li">
                        <i class="fa-solid fa-check" style="color: green"></i>
                    </span>
                    Historia cen
                </li>
                <li>
                    <span class="fa-li">
                        <i class="fa-solid fa-check" style="color: green"></i>
                    </span>
                    Weryfikacja wiarygodności promocji
                </li>
                <li>
                    <span class="fa-li">
                    <i class="fa-solid fa-person-digging"></i>
                    </span>
                    <span class="text-muted">Porównywanie cen produktów</span>
                </li>
            </ul>
        </div>
        <div class="col-lg-12">
            <a class="show-products btn btn-warning pt-2 pb-2 ps-4 pe-4 mt-4" href="{{route('products.index')}}" role="button">Zobacz aktualne ceny produktów</a>
            <p class="text-muted mt-2" style="font-size: 10px;">*
                Dolina Noteci posłużyła jako przykład zbioru produktów do analizy cen.
                Niniejsza aplikacja internetowa nie ma na celu działań konkurencyjnych wobec fimy Dolina Noteci.
            </p>
        </div>
    </div>
    <div class="col-lg-6">
        <!-- 
            Img author: Matthew Jedrzejewski
            https://dribbble.com/MattJedrzejewski
        -->
        <img class="img-fluid" src="{{ asset('images/website.gif') }}">
    </div>
</div>



@endsection