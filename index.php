<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ovládání pro KeepCube z webového rozhraní">
    <meta name="author" content="Dominik Kadera">
    <meta http-equiv="cache-control" content="no-cache" />
    <title>KeepCube WEB-UI</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
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
    <?php
        include("dbconn.php");
        $bfr = mysql_query("SELECT temp, hum, press FROM sensor_readings ORDER BY cts DESC LIMIT 1");
        $bfr2 = mysql_fetch_array($bfr);
        $hum = $bfr2[1];
        $temp = $bfr2[0];
        $press = $bfr2[2];
        $output = mysql_query("SELECT * FROM switches LEFT JOIN rooms ON switches.room_id = rooms.room_id");
        $pocetRadku = mysql_num_rows($output);
    ?>
    <header id="header" role="banner">
        <div class="container">
            <div id="navbar" class="navbar navbar-default">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Menu</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="."></a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href=#htp><i class="icon-home"></i> HOME</a></li>
                        <li><a href="#swr"><i class="icon-lightbulb"></i> CHYTRÉ PRVKY</a></li>
                        <li><a href="#adr"><i class="icon-cog"></i> MÍSTNOSTI</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!-- METEOINFO -->
    <section id="htp">
        <div class="container meteoData">
            <div class="first center">
                <div class="col-lg-4 box col-sm-4">
                    <h3>Vlhkost</h3>
                    <img src="images/ico/hum.png" class="icon-lg-nbg" alt="IMG HUMIDITY">
                    <h4 class="res">
                        <?php echo $hum; ?>
                        %
                    </h4>
                    <a href="#">
                        <button class="btn btn-primary btn-lg">
                            PODROBNOSTI
                        </button>
                    </a>
                </div>
                <div class="col-lg-4 box col-sm-4">
                    <h3>Teplota</h3>
                    <img src="images/ico/temp.png" class="icon-lg-nbg" alt="IMG TEMPERATURE">
                    <h4 class="res">
                        <?php echo $temp; ?>
                         °C
                    </h4>
                    <a href="#">
                        <button class="btn btn-primary btn-lg">
                            PODROBNOSTI
                        </button>
                    </a>
                </div>
                <div class="col-lg-4 box col-sm-4">
                    <h3>Tlak</h3>
                    <img src="images/ico/press.png" class="icon-lg-nbg" alt="IMG PRESSURE" width="40%">
                    <h4 class="res">
                        <?php echo $press; ?>
                         Pa
                    </h4>
                    <a href="#">
                        <button class="btn btn-primary btn-lg">
                            PODROBNOSTI
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- VYPÍNAČE -->
    <section id="swr">
        <div class="container switchesRooms">
            <div>
                <div class="col-lg-12 box">
                            <?php
                                if($pocetRadku != 0)
                                {
                                    echo('<h3>CHYTRÉ PRVKY</h3><p>Odtud můžete ovládat přidané chytré prvky. Pokud chcete přidat nový chytrý prvek do domácnosti, využijte možnosti níže.</p><table class="table"><thead><td>MÍSTNOST</td><td>NÁZEV</td><td>TYP</td><td></td><td></td><td></td><td></td></thead><tbody>');
                                    for($i = $pocetRadku; $i > 0; $i--)
                                    {
                                        $radek = mysql_fetch_array($output);
                                        echo('<tr><td>');
                                        echo($radek[7]);
                                        echo('</td><td>');
                                        echo($radek[2]);
                                        echo('</td><td>');
                                        echo($radek[5]);
                                        echo('</td><td><a href=sender.php?code=');
                                        echo($radek[3]);
                                        echo('><button class="btn btn-sm btn-success">ON</button></a></td><td><a href=sender.php?code=');
                                        echo($radek[4]);
                                        echo('><button class="btn btn-sm btn-danger">OFF</button></a></td>');
                                        if($radek[5]=="LED")
                                        {
                                            echo('<td><form action="sender.php" method=get><input type=color name=ledcol value="#ffffff"> <input name="code" type=hidden value="lcc"><button type="submit" class="btn btn-warning btn-sm">Změnit barvu</button></form></td>');
                                        }
                                        else
                                        {
                                            echo("<td></td>");
                                        }
                                        echo('<td><a href="inserter.php?code=sr&id=');
                                        echo($radek[0]);
                                        echo('"><button class="btn btn-sm btn-danger">VYMAZAT</button></a></tr>');
                                    }
                                    echo("</tbody></table>");
                                }
                                else
                                {
                                    echo("<h3 class=center>Nebyly nalezeny žádné chytré prvky</h3>");
                                }
                                $output = mysql_query("SELECT * FROM rooms");
                                $mistnosti = $output;
                                $pocetRadku = mysql_num_rows($output);
                            ?>
                        <div id="def">
                        <div id="popupContact">
                            <form action="inserter.php" id="form" method="get" name="form" class="pp">
                                <img id="close" alt="ZAVRI" src="images/ico/close.png" onclick ="div_hide2()" width="30px">
                                <h3>PŘIDÁNÍ NOVÉHO PRVKU</h3>
                                <hr>
                                <?php
                                    if($pocetRadku != 0)
                                    {
                                        echo('<input id="nazev" name="nazev" placeholder="Název prvku" type="text" required>
                                              <label for="select">Vyberte místnost:</label>
                                              <br />
                                              <select id="select" name="select">');
                                        for($j = $pocetRadku; $j > 0; $j--)
                                        {
                                            $flek = mysql_fetch_array($mistnosti);
                                            echo("<option>");
                                            echo($flek[1]);
                                            echo("</option>");
                                        }
                                        echo('</select>
                                            <select id="type" name="type">
                                            <option>Vypínač</option>
                                            <option>LED</option>
                                            </select>
                                            <input id="code" name="code" type="hidden" value="sa">
                                            <hr>
                                            <a href="javascript:%20check_empty()" id="submit">
                                            <button class="btn btn-sm btn-success">
                                            PŘIDAT
                                            </button>
                                            </a>');
                                    }
                                    else
                                    {
                                        echo("<h4>Není kam vložit chytré prvky, vytořte prosím nejdříve místnosti.");
                                    }
                                ?>
                            </form>
                        </div>
                    </div>
                    <div class="btnBox center">
                        <button id="popup" class="btn btn-lg btn-primary" onclick="div_show2()">
                            PŘIDAT CHYTRÝ PRVEK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- SETUP MÍSTNOSTÍ -->
    <section id="adr">
        <div class="container roomList">
            <div class="first center">
                <div class="col-lg-12 box">
                            <?php
                                $output = mysql_query("SELECT * FROM rooms");
                                $pocetRadku = mysql_num_rows($output);
                                if($pocetRadku != 0)
                                {
                                    echo('<h3>SEZNAM MÍSTNOSTÍ</h3><table class="table"><thead><td>NÁZEV MÍSTNOSTI</td><td>POČET PŘIHLÁŠENÝCH PRVKŮ</td><td></td></thead><tbody>');
                                    for($i = $pocetRadku; $i > 0; $i--)
                                    {
                                        $radek = mysql_fetch_array($output);
                                        echo('<tr><td>');
                                        echo($radek[1]);
                                        echo('</td><td>');
                                        $buffik = mysql_query("SELECT COUNT(id) FROM switches WHERE room_id='$radek[0]'");
                                        $bufficek = mysql_fetch_array($buffik);
                                        echo($bufficek[0]);
                                        echo('</td><td>');
                                        echo('<a href=inserter.php?id=');
                                        echo($radek[0]);
                                        echo('&code=rr><button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Vymazáním místnosti mažete také všechny chytré prvky které obsahuje!" data-original-title="Vymazáním místnosti mažete také všechny chytré prvky které obsahuje!">VYMAZAT</button></a></td></tr>');
                                    }
                                    echo("</tbody></table>");
                                }
                                else
                                {
                                    echo("<h3>Nebyly nalezeny žádné místnosti</h3>");
                                }
                            ?>
                    <div id="abc">
                        <div id="popupContact">
                            <form action="inserter.php" id="form" method="get" name="form"  class="pp">
                                <img id="close" alt="ZAVRI" src="images/ico/close.png" onclick ="div_hide()" width="30px">
                                <h3>PŘIDÁNÍ NOVÉ MÍSTNOSTI</h3>
                                <hr>
                                <input id="nazev" name="nazev" placeholder="Název místnosti" type="text" required>
                                <input id="code" name="code" type="hidden" value="ra">
                                <hr>
                                <a href="javascript:%20check_empty()" id="submit">
                                    <button class="btn btn-sm btn-success">
                                        PŘIDAT
                                    </button>
                                </a>
                            </form>
                        </div>
                    </div>
                    <button id="popup" class="btn btn-lg btn-primary" onclick="div_show()">PŘIDAT NOVOU MÍSTNOST</button>
                </div>
            </div>
        </div>
    </section>
    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    &copy; 2016 <a target="_blank" href="http://www.uzlabina.cz/" title="Vytvořili tito pánové!">Amangers-PI</a>. All Rights Reserved.
                </div>
                <div class="col-sm-6">
                    <img class="pull-right" src="images/shapebootstrap.png" alt="ShapeBootstrap" title="ShapeBootstrap">
                </div>
            </div>
        </div>
    </footer>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
    <script src="js/popup.js"></script>
</body>
</html>