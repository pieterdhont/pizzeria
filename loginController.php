<?php
//loginController.php
declare(strict_types=1);

session_start();

require_once("bootstrap.php");

use App\Business\KlantService;
use App\Exceptions\KlantNietGevondenException;
use App\Exceptions\IncorrectWachtwoordException;

$klantService = new KlantService();

$errorMessage = "";
$emailValue = "";  

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $wachtwoord = $_POST["wachtwoord"];

    try {
        $klant = $klantService->inloggen($email, $wachtwoord);
        $_SESSION["klant"] = $klant->getKlantid();  

        if (isset($_COOKIE['mandje'])) {
            $_SESSION["mandje"] = json_decode($_COOKIE['mandje'], true);
        }
        
        
        setcookie("last_login_email", $email, time() + 60*60*24*30, "/", "", false, true);

        header("Location: orderView.php");
        exit;
    } catch (KlantNietGevondenException $e) {
        $errorMessage = "Deze e-mail is niet geregistreerd.";
    } catch (IncorrectWachtwoordException $e) {
        $errorMessage = "Verkeerd wachtwoord ingevoerd.";
    }
} else {
    
    if (isset($_COOKIE["last_login_email"])) {
        $emailValue = $_COOKIE["last_login_email"];
    }
}

echo $twig->render('login.twig', ["errorMessage" => $errorMessage, "email" => $emailValue]);
