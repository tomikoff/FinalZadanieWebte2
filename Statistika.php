<?php
//whether ip is from share internet
if (!empty($_SERVER['HTTP_CLIENT_IP']))   
  {
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
  }
//whether ip is from proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
  {
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
//whether ip is from remote address
else
  {
    $ip_address = $_SERVER['REMOTE_ADDR'];
  }
//echo $ip_address;

//statistiky
              include "dbconfig.php";
              try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn->exec("set names utf8 " );
                $sql3 = "SELECT ip,country,PocetLOG FROM Mashup";

                $navsteva;
                $counter = 0;
                $result2 = array();

                $result2 = $conn->query($sql3);
                foreach($result2 as $r)
                {

                  $navsteva = $r[2];
                  $counter = $counter + 1;
                  
                }
                $navsteva = "Pocasie";
              }
              catch(PDOException $e)
              {
              echo "Connection failed: " . $e->getMessage();
              }
            
function VypisTabulku(){
            include "dbconfig.php";
            try {
              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
              // set the PDO error mode to exception
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $conn->exec("set names utf8 " );
              
              $today = date("Y-m-d"); 

              $sql2 = "SELECT ip,country,PocetLOG,Countrycod FROM Mashup";

              $counter = 0;
              $result = array();

              $result = $conn->query($sql2);

              $IPpomoc = 1;
              $Pocetlogov = 1;

              echo '<div class="container">
                <h2>Návštevníci</h2>
                            
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>IP</th>
                      <th>Krajina</th>
                      <th>Pocet Prihlásení</th>
                    </tr>
                  </thead>
                  <tbody>';
                    
                  

              foreach($result as $r)
              {
                $loweer = $r[3];
                $loweer = strtolower($loweer);
                
                echo '<tr>
                      <td> ' . $r[0].' </td>
                      <td>'. $r[1] . '<div><img src="http://www.geonames.org/flags/x/'.$loweer.'.gif" onclick="sortTable()" width="70" height="50" > </div> </td>
                      <td> '. $r[2] . '</td>
                    </tr>
                           ';
                $counter = $counter + 1;
                
              }

              echo '</tbody>
                </table>
              </div>
              '
              ;

              
              //echo "<p id='stats'> Dokopy máme $counter návštevníkov </p>";
              
              
              
              }
              catch(PDOException $e)
              {
              echo "Connection failed: " . $e->getMessage();
              }
            }
            

?>



<!DOCTYPE html>
<html>
<head>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  
<title>Mashup</title>




</head>
<body>
<h1> Mashup By T Š</h1>

<nav>
            <ul>
                <li><a href="http://147.175.121.210:8108/zadanie7/index.php">Počasie</a></li>
                <li><a href="http://147.175.121.210:8108/zadanie7/GPS.php">GPS</a></li>
                 <li><a href="http://147.175.121.210:8108/zadanie7/Statistika.php">Štatistika</a></li>
                 
                 
             </ul>
         </nav>

<script> 
function sortTable()
{
  alert("Počet prihlásení je vypísaný vpravo od vlajky :)");
}
</script>

<div id="zakladne">
 
 <p id = "NEW"> Vitajte v štatistikách </p>
 <p id = "stats"> Dokopy máme <?php echo $counter; ?> návštevníkov <br> Najnavštevovanejšia stránka je <?php echo $navsteva;?></p>
 
  <?php VypisTabulku();?>
 
</div>
</body>
</html>