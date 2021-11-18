<!DOCTYPE html>
<html lang="en">
<head>
    <link rel ='stylesheet' type = 'text/css' href = 'index.css'>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estereos</title>
</head>
<body>
    <h1>Venta de estereos</h1>
    <div class="container">
        <form id ="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" onsubmit= "estereos();">
            <input type="text" name="datos" id="input">
            <br><br>
            <select name="select" id="select">
                <option value="1">NOSY</option>
                <option value="2">LG</option>
                <option value="3">NOBLEX</option>
            </select>
            <br><br>
            <input type="submit" value="Enviar" id="submit" name="btn">
        </form>
        <div id='res'></div>
    </div>
    <script src="app.js"></script>
</body>
</html>
<?php
if(isset($_POST['btn'])){
    $dato = $_POST['datos'];
    $producto = $dato;
    $descuento1 = $producto * 10 / 100;
    $descuento2 = $producto * 5 / 100;
    $descuentoTotal = $descuento1 + $descuento2;
    $select = $_POST['select'];

    switch ($dato) {
        case ($dato >= 2000):
            echo 'Se aplico descuento 1 <br>';
            echo 'El estero vale: '.$producto - $descuento1;
            break;

        case ($select == '1'):
            echo 'Se aplico descuento 2 <br>';
            echo 'El estero vale: '.$producto - $descuento2;
            break;

        case (($dato >= 2000) && ($select == '1')):
            echo 'Se aplico descuento 1 y 2<br>';
            echo 'El estereo vale: '.$producto - $descuentoTotal;
            break;

    default:
        echo 'No se aplico ningun descuento<br>';
        echo 'El estereo vale: '.$producto;
        break;

}

}
?>