<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>KeepCube WEB-UI</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <meta http-equiv="refresh" content="5;url=index.php">
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,500,800,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head>
<body data-spy="scroll" data-target="#navbar" data-offset="0">
    <div class="center">
        <h1>ZPRACOVÁNO</h1>
        <a href="index.php"><button class="btn btn-lg btn-info">KLIKNĚTE ZDE PRO NÁVRAT</button></a>
    </div>
    <?php
        include("dbconn.php");
        $code = $_GET["code"];
        $name = $_GET["nazev"];
        $id = $_GET["id"];
        $nazev = $_GET["select"];
        $typ = $_GET["type"];
        switch($code)
        {
            case "ra":
            if($name == " ")
            {
                die("<h2>Došlo k chybnému vstupu.</h2>");
            }
            else
            {
                mysql_query("INSERT INTO rooms (room_name) VALUES ('$name')");
            }
            break;
            case "rr":
            mysql_query("DELETE FROM switches WHERE room_id = '$id'");
            mysql_query("DELETE FROM rooms WHERE room_id = '$id'");
            break;
            case "sa":
                $oncode = rand(100000,199000);
                $offcode = rand(100000,199000);
                $q = mysql_query("SELECT room_id FROM rooms WHERE room_name = '$nazev'");
                $qa = mysql_fetch_array($q);
                $rid = $qa[0];
                mysql_query("INSERT INTO switches (nazev, room_id, on_code, off_code, type) VALUES ('$name','$rid','$oncode','$offcode','$typ')");
                break;
            case "sr":
                mysql_query("DELETE FROM switches WHERE id = '$id'");
                break;
            default:
                die("<h2>Došlo k neošetřenému vstupu.</h2>");
                break;
        }
    ?>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
    <script src="js/popup.js"></script>
</body>
</html>