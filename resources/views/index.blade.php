<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Laravel</title>
    <script>
        function updateHeure() {
            document.getElementById("Heure").innerText = new Date().toLocaleTimeString();
        }
        setInterval(updateHeure, 1000);
    </script>
</head>
<body>
    <h1>Hello World</h1>
    <p>**Heure Serveur(PHP):** {{ $heureServeur }}</p>
    <p>**Heure depuis le Server(MariaDB):** {{ $heureDB }}</p>
    <p>**Heure du client(JavaScript):** <span id="heureClient"></span></p>
    
    <script>
        function afficherHeureClient() {
            const maintenant = new Date();
            document.getElementById("heureClient").innerText = maintenant.toLocaleTimeString();
        }
        setInterval(afficherHeureClient, 1000);
        afficherHeureClient();
    </script>
</body>
</html>

