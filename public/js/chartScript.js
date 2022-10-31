function chart(type, product_id) {
    $.ajax({
        url: "/getDetailsAjax/" + product_id,
        // cache: false,
        success: function (response) {
            $.each(response, function (key, value) {
                drawChart(response[key]);
            });
        },
        error: function (response) {
            console.log(response);
        }

    });
}


function drawChart(response, chartName = "myChart", chartTitle = 'Rys 1. Zmiana ceny produktu w podanym okresie czasu') {

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
                    text: chartTitle,
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
