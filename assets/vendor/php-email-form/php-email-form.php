<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Remplace par ton email réel
$receiving_email_address = "khantouchabderrahim57@gmail.com";

// Vérification des données envoyées via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name    = isset($_POST['name']) ? strip_tags(trim($_POST['name'])) : '';
  $email   = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
  $subject = isset($_POST['subject']) ? strip_tags(trim($_POST['subject'])) : 'Message du site';
  $message = isset($_POST['message']) ? strip_tags(trim($_POST['message'])) : '';

  // Validation basique
  if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs correctement.']);
    exit;
  }

  // Construction du message email
  $email_content = "Nom: $name\n";
  $email_content .= "Email: $email\n";
  $email_content .= "Message:\n$message\n";

  $email_headers = "From: $name <$email>";

  // Envoi de l’email
  if (mail($receiving_email_address, $subject, $email_content, $email_headers)) {
    echo json_encode(['success' => true, 'message' => 'Votre message a bien été envoyé.']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'envoi du message.']);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
}
?>
