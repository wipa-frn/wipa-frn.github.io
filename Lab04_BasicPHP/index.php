<!--Wipawadee Monkhut 5910406451-->
<?php 
    session_start()
?>

<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    <head>
        <title>Lab04 Basic PHP</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="indexCss.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


        <script>

            $(document).ready(function() {
                $('input#input_text, textarea#textarea2').characterCounter();
            });
        </script>
    </head>

    
    <body>

    <?php
        ob_start();

        //define error of file
        $phpFileUploadErrors = array(
                0 => 'There is no error, the file uploaded with success',
                1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
                2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
                3 => 'The uploaded file was only partially uploaded',
                4 => 'No file was uploaded',
                6 => 'Missing a temporary folder',
                7 => 'Failed to write file to disk.',
                8 => 'A PHP extension stopped the file upload.',
        );
        //define viriable
        $firstNameErr = $lastNameErr= $emailErr = $accountNameErr = $imgTextErr = $csvTextErr = "" ; 
        $firstName = $lastName = $email = $accountName = $playlistTitle = $playlistDescription = "";  
        $imgSucces = $csvSuccess = "";  
        $imgFileName = $csvFileName = "";    
        
        
        if(isset($_POST['submit'])){

            //check feild required 
            if (empty($_POST["first_name"])) {
                $firstNameErr = "First name is required";
                
            }
            if (empty($_POST["last_name"])) {
                $lastNameErr = "Last name is required";
            }
            //name is not empty
            if(!empty($_POST["first_name"]) && !empty($_POST["last_name"])){
                $firstName = test_input($_POST["first_name"]);
                $lastName = test_input($_POST["last_name"]);
                
                //check first name and last name is not same language
                if((preg_match("/^[a-zA-Z]*$/",$firstName) && preg_match("/^[ก-๏\s]*$/",$lastName)) || 
                (preg_match("/^[ก-๏\s]*$/",$firstName) && preg_match("/^[a-zA-Z]*$/",$lastName))) {
                    $firstNameErr = $lastNameErr = "Letters of name must be same language";
                }
                //check only name letters ENG-THAI allowed
                elseif (!preg_match("/^[ก-๏\s]*$/",$firstName) && !preg_match("/^[a-zA-Z]*$/",$firstName)){
                    $firstNameErr = "Only letters ENG-THAI allowed";
                } 
                elseif(!preg_match("/^[ก-๏\s]*$/",$lastName) && !preg_match("/^[a-zA-Z]*$/",$lastName)){
                    $lastNameErr = "Only letters ENG-THAI allowed";
                }

            }
                
             //check feild required 
            if (empty($_POST["email"])) {
                $emailErr = "Email is required";

            } else {
                $email = test_input($_POST["email"]);
                // check if e-mail address is well-formed
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
            
                }
            }
             //check feild required 
            if (empty($_POST["account"])) {
                $accountNameErr = "Account name is required";
       
              } else {
                $accountName = test_input($_POST["account"]);
                //check if account name is correct
                if(!preg_match("/^@[ก-๏\s]*$/",$accountName) && !preg_match("/^@[a-zA-Z]*$/",$accountName)){
                    $accountNameErr = "Account name start with '@' and only letters ENG-THAI allowed" ;
                }

            }

            //not check validate 
            $playlistTitle = test_input($_POST["playlist_title"]);
            $playlistDescription = test_input($_POST["playlist_description"]);
 
            //assign value to session for use in another page
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            $_SESSION['email'] = $email;
            $_SESSION['account'] = $accountName;
            $_SESSION['playlistTitle'] = $playlistTitle;
            $_SESSION['playlistDescription'] = $playlistDescription;

            //validate Images file                                
            if (isset($_FILES['fileImgToUpload']) ){
                $ext_error = false;
                $extensions_img = array('jpg', 'jpeg', 'gif', 'png');           //file extension are allowed to upload
                $file_ext = explode('.',$_FILES['fileImgToUpload']['name']);    //find extension file input
                $file_ext = end($file_ext);

                //check file extension are allowed to upload
                if(!in_array($file_ext,$extensions_img)){
                    $ext_error = true;
                }
                //if file error                    
                if($_FILES['fileImgToUpload']['error']){
                    $imgTextErr = $phpFileUploadErrors[$_FILES['fileImgToUpload']['error']];
                      
                }
                //if extension file is not allowed to upload
                elseif ($ext_error){
                    $imgTextErr = "Invilid file extension";
                    
                }
                //upload file successfully
                else{
                    $imgSucces = "Upload image successfully!";

                    //move file from 'tmp' to directory 'images' 
                    move_uploaded_file($_FILES['fileImgToUpload']['tmp_name'],'images/' . $_FILES['fileImgToUpload']['name']);
                        
                }
                //assign value to session for use in another page
                $_SESSION['fileImgToUpload'] = $csvFileName =  $_FILES['fileImgToUpload']['name'];
                }

            //validate CSV file
                if (isset($_FILES['fileToUpload']) ){
                    $ext_error = false;
                    $extensions_csv = array('csv');
                    $file_ext = explode('.',$_FILES['fileToUpload']['name']);
                    $file_ext = end($file_ext);

                    //check file extension are allowed to upload
                    if(!in_array($file_ext,$extensions_csv)){
                        $ext_error = true;
                    }
                    //if file error  
                    if($_FILES['fileToUpload']['error']){
                        $csvTextErr = $phpFileUploadErrors[$_FILES['fileToUpload']['error']];
                    
                    }
                    //if extension file is not allowed to upload
                    elseif ($ext_error){
                        $csvTextErr = "Invilid file extension";
                    }
                    //upload file successfully
                    else{
                        $csvSuccess = "Upload image successfully!";

                        //move file from 'tmp' to directory 'csv' 
                        move_uploaded_file($_FILES['fileToUpload']['tmp_name'],'csv/' . $_FILES['fileToUpload']['name']);
                    }
                    //assign value to session for use in another page
                    $_SESSION['fileToUpload'] = $imgFileName = $_FILES['fileToUpload']['name'];
                }

            //validate all feild is sucessfully --> go to 'result.php' page
            if($firstNameErr == "" && $lastNameErr == "" && $emailErr == "" && $accountNameErr == "" && $imgTextErr == "" && $csvTextErr == ""){
                unset($_POST["submit"]);            
                header("Location: result.php");
                ob_end_flush();
                exit();
            }

        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }
    ?>

        <!-- Navbar goes here -->
        <nav>
            <div class="nav-wrapper">
                <a href="#" id="logo" class="brand-logo center" id="logo">My Playlist</a>
                <ul id = "template" class="right hide-on-med-and-down">
                    <li><a  href="csv-template.csv"download >Download Template</a></li>
            </div>
        </nav>
        <!-- Page Layout here -->
        <div class="row">
          
            <div class="col s3" id="column-left">
            <!-- Grey navigation panel -->
                <div class="row-left">
                    <div class="col">
                    <div class="card medium">

                        <div class="card-image">
                            <img src="add-image.png">     
                        </div>

                        <div class="card-content">
                            <p></p>
                            <p></p>
                            <p>Title :</p>
                            <p>Playlist Description : </p>
                        </div>

                    </div>
                    </div>
                </div>

            </div>
    
            <div class="col s9" id="column-right">
            <!-- Teal page content  -->
                <div class="row-right">
                    <form class="col s12" id="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                        <h5>My Playlist Form</h5><br>
                        <!--firstname + lastname-->
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="first_name" name = "first_name" type="text"  value="<?php echo $firstName; ?>">
                                <label for="first_name">*First Name</label>
                                <span class="helper-text" ><?php echo $firstNameErr ?></span>
                            </div>

                            <div class="input-field col s6">
                                <input id="last_name" name = "last_name" type="text"  value="<?php echo $lastName; ?>">
                                <label for="last_name">*Last Name</label>
                                <span class="helper-text" ><?php echo $lastNameErr ?></span>
                            </div>
                        </div>
                        <!--email + account name-->
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="email" name = "email" type="text"  value="<?php echo $email; ?>">
                                <label for="email">*Email</label>
                                <span class="helper-text" ><?php echo $emailErr ?></span>
                            </div>
                            <div class="input-field col s6">
                                <input id="account" name ="account" type="text" value="<?php echo $accountName; ?>">
                                <label for="account">*Account Name</label>
                                <span class="helper-text" ><?php echo $accountNameErr ?></span>
                            </div>
                        </div>
                        <!--playlist_title + playlist_description-->
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="input_text" name = "playlist_title" type="text" data-length="20" value="<?php echo $playlistTitle; ?>">
                                <label for="playlist_title">Playlist Title</label>
                            </div>
                
                            <div class="input-field col s12">
                                <textarea id="textarea2"  name = "playlist_description" class="materialize-textarea"  data-length="200" value="<?php echo $playlistDescription; ?>"></textarea>
                                <label for="playlist_description">Playlist Description</label>
                            </div>
                            <!--show count of string-->
                            <script>
                                $(document).ready(function() {
                                    $('input#input_text, textarea#textarea2').characterCounter();
                                });
                            </script>

                        </div>

                        <!--img upload + csv upload-->
                        <div class="row">

                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>Choose Photo</span>
                                    <input type="file" name="fileImgToUpload" >
                                </div>
                                
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" value="<?php echo $imgFileName; ?>">
                                    <span class="helper-text" ><?php echo $imgTextErr?></span>
                                </div>
                            </div>

                            <div class="file-field input-field">                                          
                                <div class="btn">
                                    <span>Choose File</span>
                                    <input type="file" name="fileToUpload" >
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" value="<?php echo $csvFileName; ?>">
                                    <span class="helper-text" ><?php echo $csvTextErr ?></span>
                                </div>
                            </div>
                        </div>


                        <div>
                            <div class="row" id ="submit-btn" >
                                <button class="btn waves-effect waves-light" type="submit" name="submit" >Submit
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </body>
</html>