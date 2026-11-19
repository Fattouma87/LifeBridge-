<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/controllers/AuthController.php';

$authController = new AuthController($pdo);
$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) ($_POST['action'] ?? '');

    if ($action === 'login') {
        $result = $authController->login(
            (string) ($_POST['email'] ?? ''),
            (string) ($_POST['password'] ?? '')
        );
        if ($result['success']) {
            header('Location: index.php');
            exit;
        }
        $error = $result['error'];
    } elseif ($action === 'register') {
        $result = $authController->register($_POST);
        if ($result['success']) {
            $success = 'Compte créé avec succès. Tu peux maintenant te connecter.';
        } else {
            $error = $result['error'];
        }
    } elseif ($action === 'logout') {
        $authController->logout();
        header('Location: index.php');
        exit;
    }
}

require_once __DIR__ . '/app/views/auth.php';