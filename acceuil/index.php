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
    
    <div class="container">
        <div class="header1">
            <div class="lignes">
                <div class="l1"></div>
                <div class="l2"></div>
            </div>

            <img src="image.jpeg" class="logo">
        </div>

        <div class="container-first">
            <h1><span>Quick </span><span>CV</span><span> & </span><span>Docs</span></h1>
            <div class="container-btns">
                <button class="btn-first b1"  onclick="window.location.href='/formulaire.php';">Commencer</button>
                <button class="btn-first b2"><a href="#emailForm">Regénérer mon cv</a></button>
            </div>
        </div>
    </div>

    <div id="emailForm">
        <p>
            <span>
                Et si vous avez déjà générer votre cv une fois avec nous et que vous avez déjà enregistrer vos informations. 
            </span> <br>  
            Vous pouvez le regénérer en entrant tout simplement votre email.
        </p>
        <form action="/fetchUserInfoFromDb.php" method="post">
            <label for="email">Entrez votre email :</label>
            <input type="email" name="email" id="email" required> <br>
            <button type="submit">Soumettre</button>
        </form>
    </div>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
    <script src="app.js"></script>
</body>
</html>