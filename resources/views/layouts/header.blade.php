<nav class="navbar navbar-expand-lg  p-3 mb-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{route('home')}}">
            <h3>Pricebot <i class="fa-solid fa-sack-dollar text-warning" style="font-size: 27px;"></i></h3>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('home')}}">
                        @if(route('home') == Request::url())
                        <span class="fw-bold text-black">Strona główna</span>
                        @else
                        <span class="text-black">Strona główna</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('products.index')}}">
                        @if(route('products.index') == Request::url())
                        <span class="fw-bold text-black">Produkty</span>
                        @else
                        <span class="text-black">Produkty</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('discount.index')}}">
                        @if(route('discount.index') == Request::url())
                        <span class="fw-bold text-black">Zweryfikowane promocje</span>
                        @else
                        <span class="text-black">Zweryfikowane promocje</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('compare.index')}}">
                        @if(route('compare.index') == Request::url())
                        <span class="fw-bold text-black">Porównaj produkty</span>
                        @else
                        <span class="text-black">Porównaj produkty</span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>