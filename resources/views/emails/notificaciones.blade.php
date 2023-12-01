<!DOCTYPE html>
<html>
<head>
    <title></title>

    <!--
	You can put your custom CSS if you wish
    -->
</head>
<body>
    <p>Estimado : {{ $user['name'] }}</p></br>
    <p>{{ $user['mensaje'] }}</p></br>
    <p>Datos de acceso:</p></br>
    <p>Email: {{ $user['email'] }}</p>
    <p>Contraseña: {{ $user['pass'] }}</p></br></br></br>
    <p>Gracias por utilizar nuestros servicios.</p>
</body>
</html>