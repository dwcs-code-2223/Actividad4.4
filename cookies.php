<?php
ob_start();
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cookies</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    </head>
    <body>

        <div class="container-fluid">
            <h1>Introduzca datos para crear cookiwa</h1>
            <?php
            print_r($_COOKIE);
            $array_duration_name = "duration";

            if (count($_COOKIE) > 0) {
                ?>
                <table class="table">
                    <thead>
                        <tr>

                            <th scope="col">Cookie name</th>
                            <th scope="col">Cookie value</th>
                            <th scope="col">Cookie duration</th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($_COOKIE as $key => $value): ?>
                            <tr>

                                <td><?= $key ?></td>
                                <!-- 2nd td -->
                                <?php if (is_array($value)) { ?>
                                    <td>  <?php print_r($value); ?> </td>

                                <?php } else { ?>
                                    <td><?= $value ?></td>
                                <?php } ?>
                                <!-- 3rd td -->
                                <td><?php
                                    if (!is_array($value)) {
                                       echo $_COOKIE[$array_duration_name][$key];
                                        
                                        
                                    }
                                    
                                    ?></td>
                            </tr>
                            <?php
                        endforeach;
                        ?>

                    </tbody></table>
                <?php
            }

            if (isset($_POST["borrar"])) {
                foreach ($_COOKIE as $key => $value) {
                    if (is_array($value)) {
                        foreach ($value as $nombreCookie => $duration) {
                            setcookie($array_duration_name .
                                    "[" . $nombreCookie . "]", '', time() - 1000);
                        }
                    } else {
                        setcookie($key, "", time() - 1000);
                    }
                }
                header("location: cookies.php");
                exit;
            }
            if (isset($_POST["name"]) && isset($_POST["value"])) {
                $nombre = $_POST["name"];
                $valor = $_POST["value"];
                $seconds = 0;

                if (isset($_POST["seconds"])) {
                    $seconds = (int) $_POST["seconds"];
                    echo "Segundos: $seconds";
                }

                setcookie($nombre, $valor, (($seconds !== 0) ? (time() + $seconds) : $seconds));
                setcookie($array_duration_name . "[" . $nombre . "]",
                        $seconds, (($seconds !== 0) ? (time() + $seconds) : $seconds));
                //Como no se especificaba, también podríais usar 0 como 3er argumento
                //setcookie($array_duration_name."[".$nombre."]", $seconds);

                header("location: cookies.php");
                exit;
            }
            ?>

            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-6">
                    <form method="post">
                        <!-- Titulo input -->
                        <div class="form-group mb-4 ">
                            <label class="form-label" for="name">Cookie:</label>
                            <input type="text" id="name" class="form-control" name="name"  required/>

                        </div>                    
                        <div class="form-group mb-4 ">
                            <label class="form-label" for="value">Cookie value:</label>
                            <input type="text" id="value" class="form-control" name="value"  required/>

                        </div> 
                        <div class="form-group mb-4 ">
                            <label class="form-label" for="seconds">Cookie expiration seconds</label>
                            <input type="number" id="seconds" class="form-control" name="seconds" min="0" />

                        </div> 

                        <!-- Submit button -->
                        <input type="submit" class="btn btn-primary btn-block mb-4" value="Añadir cookie"></button>


                    </form>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-6">
                    <form method="post">
                        <!-- Submit button -->
                        <input type="submit" name="borrar" class="btn btn-secondary btn-block mb-4" value="Borrar cookies"></button>


                    </form>
                </div>
            </div>
            <?php
            ob_end_flush();
            ?>
    </body>
</html>
