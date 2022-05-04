<?php

// require "(CONFIG NAAR DATABASE)";

session_start();

// Checkt of de token niet niks is
if (isset($_POST["token"])) {
    // Checkt of de token van de form klopt met die van de sessie
    if (hash_equals($_SESSION["token"], $_POST["token"])) {
        // Checkt of de user en pass is ingevuld, zo niet? Krijgt netjes een melding via Ajax
        if (empty($_POST["user"]) || empty($_POST["pass"])) {
            exit("Vul alle velden in");
        } else {
    
            $user = $_POST["user"];
            $pass = $_POST["pass"];
            // Zorgt dat er geen SQL injections kunnnen plaatsvinden
            $query = $pdo->prepare("SELECT * FROM (TABEL) WHERE (USERNAME)=:user");
            $query->bindParam("user", $user, PDO::PARAM_STR);
            $query->execute();
            
            $result = $query->fetch(PDO::FETCH_ASSOC);
    
            if (!$result) {
                echo "Niet gevonden in database";
            } else {
                // Checkt of de password klopt met die van de passwordhash in de database
                if (password_verify($pass, $result["(PASSWORD)"])) {
                    session_regenerate_id();
                    $_SESSION["authenticated"] = TRUE;
                    $_SESSION["user"] = $user;

                    echo '<script>location.href="index.php";</script>' ;
                    
                } else {
                    echo "Fout wachtwoord";
                }
            }
        }
    } else {
        unset($_SESSION["token"]);
        echo "Foute token";
    }
}


?>
