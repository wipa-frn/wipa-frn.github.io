<!--Wipawadee Monkhut 5910406451-->
<?php 
session_start()
?>
<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    <head>
        <title>Lab04 Basic PHP - Result</title>
        
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="resultCss.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    </head>

    <body>

    <?php
        //define viriable

        $firstName = $lastName = $email = $accountName = $playlistTitle = $playlistDescription = ""; 
        $firstName = $_SESSION['firstName'];
        $lastName = $_SESSION['lastName'];
        $email = $_SESSION["email"];
        $accountName = $_SESSION["account"];
        $playlistTitle = $_SESSION["playlistTitle"];
        $playlistDescription = $_SESSION["playlistDescription"];
        $fileImgName = $_SESSION['fileImgToUpload'];
        $fileCsvName = $_SESSION['fileToUpload'];
    
    ?>

        <!-- Navbar goes here -->
        <nav>
            <div class="nav-wrapper">
            <a href="#" class="brand-logo center">My Playlist</a>

            </div>
        </nav>

        <!-- Page Layout here -->
        <div class="row">

            <div class="col s3 " id="column-left">
                <!-- Grey navigation panel -->
                <div class="row-left">
                    <div class="col">
                        <div class="card"> 
                            <div class="card-image">
                                <?php 
                                    if(empty($fileImgName) ){
                                        echo "<img src=\" add-image.png\"";
                                    }
                                    else{
                                        echo "<img src=\"" . $fileImgName . "\"";
                                    }
                                ?>

                            </div>
                                
                            <div class="card-content">
                                <h6>Title : <?php echo $playlistTitle ?></h6>
                                <p>Playlist Description : <?php echo $playlistDescription ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            

        </div>

        <div class="col s9 " id = "your_playlist" >    
            <h4>Welcome to your playlist</h4>
            Welcome~ <?php echo "$firstName $lastName" ; ?><br>
            Account : <?php echo $accountName ?><br>
            Your email address is: <?php echo $email ?><br>
        </div>
        
        </div class = "row">
            <div class="col s12" >
                <!-- Teal page content  -->
                <div class="column-right">

                    <div class = "table-music">
                        <table class="striped responsive-table" >
                            <thead >
                                <tr>
                                    <th>Song/Album</th>
                                    <th>Artist</th>
                                    <th>Price</th>
                                    <th>Time</th>
                                </tr>
                            </thead>

                            <tbody>
                                
                                <!--create table + calculate total price + total songs + total time-->
                                <?php

                                    $row = 1;
                                    $totalPrice = 0;
                                    $secconds = 0;
                                    $minutes = 0;
                                    $hour = 0;

                                    //open file '.csv'
                                    $fileCSV = fopen('csv' . "\\" . $fileCsvName,"r");
                                    if ($fileCSV !== FALSE) {
                                        while (($data = fgetcsv($fileCSV, 1000, ",")) !== FALSE) {

                                            if ($row > 1 ){
                                                //cal total price
                                                $totalPrice += $data[2];

                                                //cal total time
                                                $timeArr = explode(":",$data[3]);
                                                $hour += $timeArr[0];
                                                $minutes += $timeArr[1];
                                                $secconds += $timeArr[2];
                                                //create row 
                                                echo "<tr>";
                                                echo "<td>" . $data[0] . "</td>";
                                                echo "<td>" . $data[1] . "</td>";
                                                echo "<td>" . $data[2] . "</td>";
                                                echo "<td>" . $data[3] . "</td>";
                                                echo "</tr>";
                                            }
                                            $row++;
                                                
                                        }
                                            
                                        //cal time 
                                        if($secconds >= 60 ){
                                            $minutes += floor($secconds / 60);
                                            $secconds = $secconds % 60;
                                        }
                                        if($minutes >= 60){
                                            $hour += floor($minutes / 60);
                                            $minutes = $minutes % 60;
                                        }

                                        $totalSongs = $row--;
                                        echo "You have " . $totalSongs . " songs in playlist.<br>";
                                        echo "Total Price : " . $totalPrice . " Baht.<br>";
                                        echo $hour . " Hours " . $minutes . " Minutes " . $secconds . " Secconds";
                                        
                                        fclose($fileCSV);
                                    }

                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>

        </div>

        

     
    </div>

    <div class = "back">
        <br>
        <a href="index.php" class="waves-effect waves-light btn-small" >BACK</a>
    </div>
    <p class = "credit">Created by Wipawadee Monkhut 5910406451</p><br>
    </body>
</html>