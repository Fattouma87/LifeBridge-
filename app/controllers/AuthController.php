<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/user.php';

class AuthController
{
    private User $userModel;

    public function __construct(PDO $pdo)
    {
        $this->userModel = new User($pdo);
    }

    public function login(string $email, string $password): array
    {
        $email = trim($email);

        if ($email === '' || $password === '') {
            return ['success' => false, 'error' => 'Veuillez renseigner votre e-mail et votre mot de passe.'];
        }

        $user = $this->userModel->verifyCredentials($email, $password);
        if ($user === null) {
            return ['success' => false, 'error' => 'Identifiants invalides.'];
        }

        session_regenerate_id(true);
        $_SESSION['user'] = $user;

        return ['success' => true, 'user' => $user];
    }

    public function register(array $input): array
    {
        $fullName = trim((string) ($input['full_name'] ?? ''));
        $email = trim((string) ($input['email'] ?? ''));
        $password = (string) ($input['password'] ?? '');
        $role = (string) ($input['role'] ?? 'donor');
        $bloodGroup = ($input['blood_group'] ?? '') !== '' ? (string) $input['blood_group'] : null;
        $city = trim((string) ($input['city'] ?? '')) !== '' ? trim((string) $input['city']) : null;

        $allowedRoles = ['donor', 'center'];
        if (!in_array($role, $allowedRoles, true)) {
            $role = 'donor';
        }

        if ($fullName === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
            return ['success' => false, 'error' => 'Données invalides (nom requis, e-mail valide, mot de passe >= 6 caractères).'];
        }

        if ($this->userModel->findByEmail($email) !== null) {
            return ['success' => false, 'error' => 'Cet e-mail est déjà utilisé.'];
        }

        $userId = $this->userModel->create([
            'full_name' => $fullName,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'blood_group' => $bloodGroup,
            'city' => $city,
        ]);

        return ['success' => true, 'user_id' => $userId];
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        session_destroy();
    }
}