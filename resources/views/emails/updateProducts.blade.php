<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Pricebot</title>
</head>
<body>
    <h4>Dzisiejsza aktualizacja: </h4>
    <p>Wszystkich produktów pobranych z seeda: {{$content['total']}}</p>
    <p>Dodano nowych: {{$content['created']}}</p>
    <p>Zaktualizowano: {{$content['updated']}}</p>
    <p>Aktywowano w bazie danych: {{$content['enabled']}}</p>
    <p>Wyłączono w bazie danych: {{$content['disabled']}}</p>
</body>
</html>
