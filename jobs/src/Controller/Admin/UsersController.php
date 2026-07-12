<?php
namespace Admin;

class UsersController {
    private $authentication;
    
    public function __construct($authentication) {
        $this->authentication = $authentication;
    }
    
    public function list() {
        if (!$this->authentication->isLoggedIn()) {
            header('Location: /admin/login');
            exit;
        }
        
        $pdo = getDB();
        $userTable = new \DatabaseTable($pdo, 'users', 'id');
        $users = $userTable->findAll('username');
        
        $categoryTable = new \DatabaseTable($pdo, 'category', 'id');
        $navCategories = $categoryTable->findAll('name');
        
        $title = "Manage Users";
        
        ob_start();
        include TEMPLATE_PATH . 'admin_users.html.php';
        $content = ob_get_clean();
        
        ob_start();
        include TEMPLATE_PATH . 'layout.html.php';
        return ob_get_clean();
    }
    
    public function add() {
        if (!$this->authentication->isLoggedIn()) {
            header('Location: /admin/login');
            exit;
        }
        
        $pdo = getDB();
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $role = $_POST['role'] ?? 'staff';
        
        if (empty($username) || empty($password) || empty($name)) {
            $_SESSION['error'] = 'All fields are required';
            header('Location: /admin/users');
            exit;
        }
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $userTable = new \DatabaseTable($pdo, 'users', 'id');
        $existing = $userTable->findAll(null, 'username = :username', ['username' => $username]);
        if (!empty($existing)) {
            $_SESSION['error'] = 'Username already exists';
            header('Location: /admin/users');
            exit;
        }
        
        $userTable->save([
            'username' => $username,
            'password' => $hashedPassword,
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'active' => 1
        ]);
        
        $_SESSION['success'] = 'User added successfully';
        header('Location: /admin/users');
        exit;
    }
    
    public function delete() {
        if (!$this->authentication->isLoggedIn()) {
            header('Location: /admin/login');
            exit;
        }
        
        $pdo = getDB();
        $id = $_POST['id'] ?? 0;
        
        $user = $this->authentication->getUser();
        if ($id == $user['id']) {
            $_SESSION['error'] = 'Cannot delete your own account';
            header('Location: /admin/users');
            exit;
        }
        
        $userTable = new \DatabaseTable($pdo, 'users', 'id');
        $userTable->save([
            'id' => $id,
            'active' => 0
        ]);
        
        $_SESSION['success'] = 'User deactivated';
        header('Location: /admin/users');
        exit;
    }
}