<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSAP Accueil</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap" rel="stylesheet">
</head>
<body>
    
    <div class="lignes">
        <div class="l1"></div>
        <div class="l2"></div>
    </div>

    <div class="container-first">
        <h1><span>Quick </span><span>CV</span><span> & </span><span>Docs</span></h1>
        <div class="container-btns">
            <button class="btn-first b1"  onclick="window.location.href='/formulaire.php';"> CV</button>
            <button class="btn-first b2"  onclick="window.location.href='/formulaire.php';">formulaire</button>
        </div>
    </div>

    <img src="image.jpeg" class="logo">



    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
    <script src="app.js"></script>
</body>
</html>