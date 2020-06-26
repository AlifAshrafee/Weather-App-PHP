<?php
$weather = "";
$error = "";
if (array_key_exists("city", $_GET)) {

    $urlContents = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($_GET["city"]) . "&appid=b3ba66eb7b1000fae06bca5f4672739a");

    $weatherArray = json_decode($urlContents, true);

    //print_r($weatherArray);

    if ($weatherArray["cod"] == 200) {
        $weather = "<b>" . $_GET["city"] . " weather summary</b><br> Condtion: " . $weatherArray["weather"][0]["main"] . "<br> Description: " . $weatherArray["weather"][0]["description"] . "<br> Temperature: " . round($weatherArray["main"]["temp"] - 273.15) . " &deg;C" . "<br> Humidity: " . $weatherArray["main"]["humidity"];
    } else {
        $error = "The city name you entered couldn't be found";
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
                <input type="text" class="form-control" id="city" name="city" aria-describedby="emailHelp" placeholder="Eg. New York, Dhaka" value="<?php
                                                                                                                                                    if (array_key_exists("city", $_GET)) {
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