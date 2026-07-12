<?php
/**
 * Authentication Class - Handles user login and session management
 */
class Authentication {
    private DatabaseTable $usersTable;
    private array $sessionData = [];

    public function __construct(DatabaseTable $usersTable) {
        $this->usersTable = $usersTable;

        if (session_status() === PHP_SESSION_NONE && php_sapi_name() !== 'cli') {
            session_start();
        }

        if (php_sapi_name() === 'cli') {
            $this->sessionData = &$_SESSION;
        }
    }

    public function login(string $username, string $password): bool {
        $users = $this->usersTable->findAll(
            null,
            'username = :username',
            ['username' => $username]
        );

        if (empty($users)) {
            return false;
        }

        $user = $users[0];

        if (
            (int)$user['active'] !== 1 ||
            !password_verify($password, $user['password'])
        ) {
            return false;
        }

        if (php_sapi_name() !== 'cli') {
            session_regenerate_id(true);
            $_SESSION['user'] = $user;
        } else {
            $this->sessionData['user'] = $user;
        }

        return true;
    }

    public function isLoggedIn(): bool {
        if (php_sapi_name() === 'cli') {
            return isset($this->sessionData['user'])
                && (int)$this->sessionData['user']['active'] === 1;
        }

        return isset($_SESSION['user'])
            && (int)$_SESSION['user']['active'] === 1;
    }

    public function getUser(): ?array {
        if (php_sapi_name() === 'cli') {
            return $this->sessionData['user'] ?? null;
        }

        return $_SESSION['user'] ?? null;
    }

    public function logout(): void {
        if (php_sapi_name() === 'cli') {
            unset($this->sessionData['user']);
            return;
        }

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