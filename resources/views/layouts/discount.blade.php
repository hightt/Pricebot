@extends('index')
@section('content')
<script type="text/javascript" src="{{ asset('libraries/chart.js') }}"></script>

<div id="root" class="container">
    <div id="chartBox" cass="row">
        <h3 class="chartTitle text-center"></h3>

    </div>



    <div class="d-none">
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Button with data-bs-target
        </button>
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <table  id="tableTemplate" class="table d-none">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">Data</th>
                            <th class="text-center" scope="col">Cena</th>
                        </tr>
                    </thead>
                    <tbody id="tableTemplateBody">
                        <tr id="tableTemplateTr" class="d-none">
                            <td class="date">1</td>
                            <td class="price">1</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>





</div>
<script>
    $(document).ready(function() {

        function getProducts() {
            $.ajax({
                url: "{{route('discount.biggest')}}",
                success: function(response) {
                    drawChart(response.result);
                },
                error: function(response) {
                    console.log(response);
                }

            });
        }

        function drawChart(products) {
            let i = 0;
            $.each(products, function(key, product) {
                let canvas = "<canvas id='chart" + i + "'></canvas>";
                let box = $("#chartBox").clone();
                let tableCollapse = "";
                let tableTemplateBox = $("#tableTemplate").clone().removeClass("d-none");

                box.find(".chartTitle").html("<a class='discount-title' href='/products/ " + product.id + "'>" + product.name + "</a>");
                box.append(canvas).append("<hr>");

                drawTable(product, tableTemplateBox);
                box.append(tableTemplateBox);

                $("#root").append(box);
                createChart(product, "chart" + i, i);
                i++;
            });
        }

        function drawTable(product, table) {
            var i = 0;
            $.each(product.axis_data.oxAxis, function(key, value) {
                if (i % 14 == 0) {
                    let oxAxis = value; // date
                    let oyAxis = product.axis_data.oyAxis[key]; //price

                    let tr = table.find("#tableTemplateTr").clone().removeClass('d-none');
                    tr.removeAttr("id");
                    tr.find('.date:first').text(oyAxis);
                    tr.find('.price:first').text(oxAxis + " zł");
                    // console.log(tr);
                    tr.appendTo(table.find("#tableTemplateBody"));

                }
                i++;

            });
        }

        function createChart(product, chartName, chartNum) {
            const data = {
                labels: product.axis_data.oyAxis,
                datasets: [{
                    label: "Cena: ",
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: product.axis_data.oxAxis
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
                            text: "Rys. " + ++chartNum + " " + product.name,
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
                document.getElementById(chartName),
                config
            );
        }


        getProducts();
    });
</script>

@endsection