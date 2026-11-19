<?php

declare(strict_types=1);

$currentUser = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>LifeBridge - Authentification</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 780px; margin: 30px auto; padding: 0 16px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 20px; }
        .card { border: 1px solid #ccc; border-radius: 8px; padding: 16px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, select, button { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; }
        button { margin-top: 14px; cursor: pointer; }
        .error { background: #ffe6e6; color: #900; padding: 10px; border-radius: 6px; margin-top: 12px; }
        .success { background: #e6ffed; color: #064; padding: 10px; border-radius: 6px; margin-top: 12px; }
    </style>
</head>
<body>
    <h1>LifeBridge — Espace Authentification</h1>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <?php if ($currentUser !== null): ?>
        <div class="card">
            <h2>Connecté en tant que : <?= htmlspecialchars($currentUser['full_name'], ENT_QUOTES, 'UTF-8') ?></h2>
            <p><strong>E-mail :</strong> <?= htmlspecialchars($currentUser['email'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Rôle :</strong> <?= htmlspecialchars($currentUser['role'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Groupe sanguin :</strong> <?= htmlspecialchars($currentUser['blood_group'] ?? 'Non précisé', ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Ville :</strong> <?= htmlspecialchars($currentUser['city'] ?? 'Non précisée', ENT_QUOTES, 'UTF-8') ?></p>

            <form method="POST">
                <input type="hidden" name="action" value="logout">
                <button type="submit">Se déconnecter</button>
            </form>
        </div>
    <?php else: ?>
        <div class="grid">
            <div class="card">
                <h2>Connexion</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="login">

                    <label for="login_email">E-mail</label>
                    <input id="login_email" type="email" name="email" required>

                    <label for="login_password">Mot de passe</label>
                    <input id="login_password" type="password" name="password" required>

                    <button type="submit">Connexion</button>
                </form>
            </div>

            <div class="card">
                <h2>Inscription</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="register">

                    <label for="reg_name">Nom complet</label>
                    <input id="reg_name" type="text" name="full_name" required>

                    <label for="reg_email">E-mail</label>
                    <input id="reg_email" type="email" name="email" required>

                    <label for="reg_password">Mot de passe (min. 6 caractères)</label>
                    <input id="reg_password" type="password" name="password" required>

                    <label for="reg_role">Rôle</label>
                    <select id="reg_role" name="role">
                        <option value="donor">Donneur (donor)</option>
                        <option value="center">Centre de don (center)</option>
                    </select>

                    <label for="reg_blood">Groupe sanguin</label>
                    <select id="reg_blood" name="blood_group">
                        <option value="">-- Optionnel --</option>
                        <option value="A+">A+</option><option value="A-">A-</option>
                        <option value="B+">B+</option><option value="B-">B-</option>
                        <option value="AB+">AB+</option><option value="AB-">AB-</option>
                        <option value="O+">O+</option><option value="O-">O-</option>
                    </select>

                    <label for="reg_city">Ville</label>
                    <input id="reg_city" type="text" name="city" placeholder="Ex: Tunis">

                    <button type="submit">Créer un compte</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>