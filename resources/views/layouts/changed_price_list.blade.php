@extends('index')
@section('content')
<script type="text/javascript" src="{{ asset('libraries/chart.js') }}"></script>
<script src="{{asset('js/chartScript.js')}}"></script>

<div id="chart-box"></div>
<div class="row" id="chart-element-layout" style="display: none">
    <div class="col-lg-4" id="details-box">
        <div class="col-lg-12" class="name">
            <i class="fa-solid fa-signature text-warning me-1"></i>
            <span class="product-name">Name</span>
        </div>
        <div class="col-lg-12" class="price-history">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Data</th>
                        <th scope="col">Cena</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr class="history-box">
                        <td class="date">12.04.2022</td>
                        <td class="price">54.04 zł</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-8" id="canvas-box"></div>
    <hr class="mb-3 mt-3">
</div>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "/getAjaxPriceHistory",
            success: function(response) {
                var j = 1;
                jQuery.each(response, function(i, product) {
                    $("#chart-element-layout").clone().attr("id", "chart-el-" + i).appendTo("#chart-box").show();
                    var box = $("#chart-el-" + i);


                    box.find("#canvas-box").append('<canvas id="chart-' + i + '"' + '></canvas>');
                    drawChart(product, "chart-" + i, "Rys " + j + ". " + product.details.name);

                    drawPriceTable(product.price_history, box);
                    j++;
                });
            },
            error: function(response) {
                console.log(response);
            }

        });

        function drawPriceTable(priceHistory, box) {

            jQuery.each(priceHistory, function(i, product) {
                // console.log(product);

                var historyBox = box.children().children().children().children().children().children();
                console.log(historyBox);
                historyBox.find('td.date').text(product.created_at_formatted);
                historyBox.find('.price').text(product.price);
            })

        }
    });
</script>

@endsection
