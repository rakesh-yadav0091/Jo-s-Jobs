<?php
namespace Admin;

class LoginController {
    private $authentication;
    
    public function __construct($authentication) {
        $this->authentication = $authentication;
    }
    
    public function loginForm() {
        if ($this->authentication->isLoggedIn()) {
            $user = $this->authentication->getUser();
            if ($user['role'] === 'client') {
                header('Location: /client/jobs');
            } else {
                header('Location: /admin/jobs');
            }
            exit;
        }
        
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if ($this->authentication->login($username, $password)) {
                $user = $this->authentication->getUser();
                if ($user['role'] === 'client') {
                    header('Location: /client/jobs');
                } else {
                    header('Location: /admin/jobs');
                }
                exit;
            }
            $error = 'Invalid username or password.';
        }
        
        $pdo = getDB();
        $categoryTable = new \DatabaseTable($pdo, 'category', 'id');
        $navCategories = $categoryTable->findAll('name');
        $title = "Admin Login";
        
        ob_start();
        include TEMPLATE_PATH . 'login.html.php';
        $content = ob_get_clean();
        
        ob_start();
        include TEMPLATE_PATH . 'layout.html.php';
        return ob_get_clean();
    }
    
    public function logout() {
        $this->authentication->logout();
        header('Location: /admin/login');
        exit;
    }
}