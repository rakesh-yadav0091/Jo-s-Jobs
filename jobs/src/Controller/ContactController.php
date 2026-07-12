<?php
class ContactController {
    private $authentication;
    
    public function __construct($authentication) {
        $this->authentication = $authentication;
    }
    
    public function contact() {
        $pdo = getDB();
        $message = '';
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = trim($_POST['firstName'] ?? '');
            $surname = trim($_POST['surname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telephone = trim($_POST['telephone'] ?? '');
            $enquiry = trim($_POST['enquiry'] ?? '');
            
            if (empty($firstName) || empty($surname) || empty($email) || empty($enquiry)) {
                $error = 'All fields except telephone are required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
            } else {
                $stmt = $pdo->prepare("INSERT INTO enquiries (firstName, surname, email, telephone, enquiry, status, createdAt) VALUES (?, ?, ?, ?, ?, 'Open', NOW())");
                $stmt->execute([$firstName, $surname, $email, $telephone, $enquiry]);
                $message = 'Thank you. We will respond shortly.';
            }
        }
        
        $categoryTable = new DatabaseTable($pdo, 'category', 'id');
        $navCategories = $categoryTable->findAll('name');
        $title = "Contact Us";
        $auth = $this->authentication;
        
        ob_start();
        include TEMPLATE_PATH . 'contact.html.php';
        $content = ob_get_clean();
        
        ob_start();
        include TEMPLATE_PATH . 'layout.html.php';
        return ob_get_clean();
    }
}