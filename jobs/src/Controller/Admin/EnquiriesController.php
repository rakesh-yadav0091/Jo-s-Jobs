<?php
namespace Admin;

class EnquiriesController {
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
        $user = $this->authentication->getUser();
        
        $sql = "SELECT e.*, u.name as staff_name 
                FROM enquiries e 
                LEFT JOIN users u ON u.id = e.completedBy 
                ORDER BY e.createdAt DESC";
        $stmt = $pdo->query($sql);
        $enquiries = $stmt->fetchAll();
        
        $categoryTable = new \DatabaseTable($pdo, 'category', 'id');
        $navCategories = $categoryTable->findAll('name');
        
        $title = "Manage Enquiries";
        
        ob_start();
        include TEMPLATE_PATH . 'admin_enquiries.html.php';
        $content = ob_get_clean();
        
        ob_start();
        include TEMPLATE_PATH . 'layout.html.php';
        return ob_get_clean();
    }
    
    public function complete() {
        if (!$this->authentication->isLoggedIn()) {
            header('Location: /admin/login');
            exit;
        }
        
        $pdo = getDB();
        $id = $_POST['id'] ?? 0;
        $user = $this->authentication->getUser();
        
        $stmt = $pdo->prepare("UPDATE enquiries SET status = 'Complete', completedBy = ?, completedAt = NOW() WHERE id = ?");
        $stmt->execute([$user['id'], $id]);
        
        $_SESSION['success'] = 'Enquiry marked as complete';
        header('Location: /admin/enquiries');
        exit;
    }
}