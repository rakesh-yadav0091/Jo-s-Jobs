<?php
/**
 * AlertController - Handles job alert subscriptions
 */
class AlertController {
    private $authentication;
    
    public function __construct($authentication) {
        $this->authentication = $authentication;
    }
    
    public function subscribeForm() {
        $pdo = getDB();
        $categoryTable = new DatabaseTable($pdo, 'category', 'id');
        $categories = $categoryTable->findAll('name');
        $navCategories = $categories;
        
        $title = "Job Alerts";
        $message = '';
        $error = '';
        
        ob_start();
        include TEMPLATE_PATH . 'alert_subscribe.html.php';
        $content = ob_get_clean();
        
        ob_start();
        include TEMPLATE_PATH . 'layout.html.php';
        return ob_get_clean();
    }
    
    public function subscribe() {
        $pdo = getDB();
        $error = '';
        $message = '';
        
        $email = trim($_POST['email'] ?? '');
        $categoryId = !empty($_POST['categoryId']) ? (int)$_POST['categoryId'] : null;
        $keywords = trim($_POST['keywords'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $frequency = $_POST['frequency'] ?? 'daily';
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } else {
            $stmt = $pdo->prepare("SELECT id FROM job_alerts WHERE email = ? AND active = 1");
            $stmt->execute([$email]);
            $existing = $stmt->fetch();
            
            if ($existing) {
                $stmt = $pdo->prepare("UPDATE job_alerts SET categoryId = ?, keywords = ?, location = ?, frequency = ? WHERE id = ?");
                $stmt->execute([$categoryId, $keywords, $location, $frequency, $existing['id']]);
                $message = 'Your job alert preferences have been updated.';
            } else {
                $stmt = $pdo->prepare("INSERT INTO job_alerts (email, categoryId, keywords, location, frequency, createdAt) VALUES (?, ?, ?, ?, ?, NOW())");
                $stmt->execute([$email, $categoryId, $keywords, $location, $frequency]);
                $message = 'You have successfully subscribed to job alerts.';
            }
        }
        
        $categoryTable = new DatabaseTable($pdo, 'category', 'id');
        $categories = $categoryTable->findAll('name');
        $navCategories = $categories;
        $title = "Job Alerts";
        $auth = $this->authentication;
        
        ob_start();
        include TEMPLATE_PATH . 'alert_subscribe.html.php';
        $content = ob_get_clean();
        
        ob_start();
        include TEMPLATE_PATH . 'layout.html.php';
        return ob_get_clean();
    }
    
    public function unsubscribe() {
        $pdo = getDB();
        $email = trim($_GET['email'] ?? '');
        if (!empty($email)) {
            $stmt = $pdo->prepare("UPDATE job_alerts SET active = 0 WHERE email = ?");
            $stmt->execute([$email]);
        }
        header('Location: /');
        exit;
    }
}