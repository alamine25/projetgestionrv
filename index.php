<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/home.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Roboto&display=swap" rel="stylesheet">
    <title>Homepage</title>
</head>

<body>
    <!-- bar de navigation -->
    <nav class="navbar navbar-inverse" aria-label="">
            <div class="container-fluid">
              <ul class="nav navbar-nav">
                <li> <a href="#Home"><em class="fa fa-home" style="font-size:16px"></em>Home</a></li>
                <li> <a href="pages/admin/admin.php"><em class='far fa-calendar-alt' style='font-size:16px'></em> Compte Administrateur</a></li>
                <li> <a href="pages/secretaire/secretaire.php"><em class='far fa-calendar-alt' style='font-size:16px'></em> Compte Secretaire</a></li>
                <li><a href="pages/medecin/medecin.php"><em class='far fa-calendar-alt' style='font-size:16px'></em> Compte Medecin</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <img src="img/bitmap.png" alt="" style="width:5rem ">
             </ul>
            </div>
    </nav>

    <!-- slider-->
    
    <div class="slidershow middle">
      <div class="slides">
         <input type="radio" name="r" id="r1" checked>
         <input type="radio" name="r" id="r2">
        <div class="slide s1">
            <img src="img/image45.jpg" alt="">
            <img src="img/who.jpg" alt="">
        </div>
      </div>
      <div class="navigation">
        <label for="r1" class="bar"></label>
        <label for="r2" class="bar"></label> 
      </div>
    </div>

    <!-- en bas de la page -->
    <div class="message">
        <h1>Bienvenu a Sen-Medic</h1>
    </div> 
</body>

</html>