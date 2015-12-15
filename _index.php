<?php
/**
 * Created by PhpStorm.
 * User: Zangles
 * Date: 21/10/2015
 * Time: 20:03
 */
if (!empty($_POST)){
    $para      = 'lennyleather@gmail.com ';
    $titulo    = 'Contacto Web';
    $mensaje   = $_POST['mensaje'];
    $cabeceras = 'From: '. $_POST['email'] . "\r\n" .
        'Reply-To: '. $_POST['email'] . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    mail($para, $titulo, $mensaje, $cabeceras);
}

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lennyba</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <style>
        .vertical-center {
            min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
            min-height: 100vh; /* These two lines are counted as one :-)       */
            /*display: flex;*/
            align-items: center;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body style="background-color: black;color:white">

<div class="vertical-center row">
    <div class="text-center col-md-3 col-md-offset-4">
        <img src="/LOGO-LENNY-BLANCO-2.png" class="img-responsive" alt="">
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3 col-md-offset-4">
                <?php if (empty($_POST)){ ?>
                    <form method="post">
                        <label for="exampleInputEmail1">Contacto</label>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <textarea  class="form-control" name="mensaje" id="" cols="30" rows="5" placeholder="Mensaje" required></textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-default">Enviar</button>
                        </div>
                    </form>
                <?php  }else{ ?>
                    <div class="text-center">
                        <label>Gracias por su mensaje.</label>
                    </div>
                <?php  } ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        &nbsp;
    </div>
    <div class="col-md-11 text-center">
        <h2>Under Construction</h2>
    </div>
    <br>
    <br>
    <div class="col-md-11 text-center">
        <p>Seguinos:</p>
    </div>
    <div class="col-md-5  text-right">
        <p>/Lenny Leather </p>
    </div>
    <div class="col-md-5 col-lg-offset-1 text-left">
        <p>@lennyLeatherBA</p>
    </div>
</div>


</body>
</html>
