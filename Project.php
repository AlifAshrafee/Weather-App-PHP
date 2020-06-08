<?php
$weather = "";
$error = "";
if (array_key_exists("city",$_GET)) {
    $city = str_replace(" ", "", $_GET["city"]);

    $file_headers = @get_headers("https://www.weather-forecast.com/locations/" . $city . "/forecasts/latest");
    if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
        $error = "The city you entered could not be found";
    } else {
        $content = file_get_contents("https://www.weather-forecast.com/locations/" . $city . "/forecasts/latest");
        $array1 = explode('Weather Today</h2> (1–3 days)</div><p class="b-forecast__table-description-content"><span class="phrase">', $content);
        if (sizeof($array1) > 1) {
            $array2 = explode('</span></p></td><td class="b-forecast__table-description-cell--js" colspan="9"><div class="b-forecast__table-description-title">', $array1[1]);
            if (sizeof($array2) > 1) {
                $weather = $array2[0];
            } else {
                $error = "The city you entered could not be found";
            }
        } else {
            $error = "The city you entered could not be found";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Weather Scraper</title>

    <style type="text/css">
        html {
            background: url(Download.jpg) no-repeat center center fixed;
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
            margin-top: 10vw;
            width: 40vw;
        }

        input {
            margin: 1vw 0;
        }

        #weather {
            margin-top: 1vw;
        }
    </style>
</head>

<body>

    <div class="container">

        <h1 class="display-4">What's the weather?</h1>

        <form>
            <div class="form-group">
                <label for="city">Enter the name of a city</label>
                <input type="text" class="form-control" id="city" name="city" aria-describedby="emailHelp" placeholder="Eg. New York, Dhaka" value=
                "<?php 
                    if (array_key_exists("city",$_GET)){
                        echo $_GET["city"];
                    }
                ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div id="weather"><?php
                            if ($weather) {
                                echo '<div class="alert alert-primary" role="alert">' . $weather . '</div>';
                            } else if ($error) {
                                echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
                            }

                            ?></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>