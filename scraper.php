
<!--   sumancsnit@gmail.com-->
   <?php
    
    $weather = "";
    $error = "";

    if (array_key_exists('city', $_GET)) {
        
        $city = str_replace(' ', '-', $_GET['city']);
        
        $file_headers = @get_headers("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        
        if ($file_headers[0] == 'HTTP/1.1 404 Not Found') {
            
            $error = "That city could not be found.";
            
        } else {
        
            $forecastPage = file_get_contents("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");

            $pageArray = explode('3 Day Weather Forecast Summary:</b><span class="read-more-small"><span class="read-more-content"> <span class="phrase">', $forecastPage);
            
            if (sizeof($pageArray) > 1) {
                
                $secondPageArray = explode("</span></span></span></p>", $pageArray[1]);
                if (sizeof($secondPageArray) > 1 ) {
                    $weather = $secondPageArray[0];
                } else {
                    $error = "That city could not be found.";   
                }
             
            } else {
                
                $error = "That city could not be found.";
            }
        }    
    }


?>

    <!doctype html>
    <html lang="en">

    <head>
        <title>Current Weather</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

        <style type="text/css">
            html {
                background: url(img/bg.jpg) no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
            
            body {
                background: none;
            }
            
            .container {
                text-align: center;
                margin-top: 100px;
                width: 450px;
            }
            
            input {
                margin: 20px 0;
            }
            
            #weather {
                margin-top: 20px;
            }
        </style>
    </head>

    <body>

        <div class="container">
            <h1>What's The Weather ?</h1>

            <form>
                <fieldset class="form-group">
                    <label for="city">Enter the name of the city.</label>
                    <input type="text" id="city" name="city" class="form-control" placeholder="Eg. Bangalore, Delhi" value="<?php
                        if (array_key_exists('city', $_GET)) {
                            echo $_GET['city']; 
                        }
                    ?>">
                </fieldset>

                <button type="submit" class="btn btn-primary">Go!</button>
            </form>

            <div id="weather">
                <?php 
                
                if ($weather) {
                    
                    echo '<div class="alert alert-success" role="alert">' .$weather.'</div>';
                    
                } else if ($error) {
                    echo '<div class="alert alert-danger" role="alert">' .$error.'</div>';   
                }
            
            ?>
            </div>
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    </body>

    </html>
