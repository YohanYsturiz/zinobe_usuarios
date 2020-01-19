
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro de Usuarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <?php
        // echo "Registro de Usuario"
    ?>
    <div class="container">
        <div class="col-10 mx-auto">
            <h1>Registro de Usuarios</h1>
            <form class="form" action="" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nombre_usuario">Nombre Completo</label>
                        <input type="text" name="nombre" id="nombre_usuario" class="form-control" placeholder="Nombre Completo">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email_usuario">Correo Electronico</label>
                        <input type="text" name="email" id="email_usuario" class="form-control" placeholder="Correo Electronico">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="documento_usuario">Numero Documento</label>
                        <input type="number" name="documento" id="documento_usuario" class="form-control" placeholder="Numero Documento">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password_usuario">Contraseña</label>
                        <input type="password" name="password" id="password_usuario" class="form-control" placeholder="Contraseña">
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

