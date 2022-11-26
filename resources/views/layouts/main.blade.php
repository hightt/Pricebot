@extends('index')


@section('content')

<div class="col-lg-12" style="min-height: 75vh;">
    <div class="row mt-5 mb-5">
        <div class="col-lg-8 align-middle mt-lg-5">
            <h3>Monitoring cen hurtowni <span class="text-warning">Dolina Noteci*</span></h3>
            <p style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sed molestie ligula. Vestibulum
                ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Vestibulum ante ipsum primis
                in faucibus orci luctus et ultrices posuere cubilia curae; Pellentesque ut felis et arcu auctor dignissim a ac erat.
                Fusce congue, quam in pretium accumsan, felis massa mollis arcu, sed semper mi sem quis metus.
            </p>
        </div>
        <div class="col-lg-4 text-center">
            <i class="fa-solid fa-sack-dollar text-warning" style="font-size: 250px;"></i>
        </div>
    </div>
    <div class="col-lg-12">
        <a class="show-products btn btn-warning pt-2 pb-2 ps-4 pe-4" href="{{route('products.index')}}" role="button">Zobacz aktualne ceny produktów</a>
    </div>
    <div class="col-lg-12">
        <p class="text-muted mt-4" style="font-size: 10px;">*
            Dolina Noteci posłużyła jako przykład zbioru produktów do analizy cen.
            Niniejsza aplikacja internetowa nie ma na celu działań konkurencyjnych wobec fimy Dolina Noteci :)
        </p>
    </div>

</div>

@endsection
