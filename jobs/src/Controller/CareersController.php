<?php
class CareersController {
    private $authentication;
    
    public function __construct($authentication) {
        $this->authentication = $authentication;
    }
    
    public function advice() {
        $pdo = getDB();
        $categoryTable = new DatabaseTable($pdo, 'category', 'id');
        $navCategories = $categoryTable->findAll('name');
        
        $title = "Careers Advice";
        $auth = $this->authentication;
        
        ob_start();
        include TEMPLATE_PATH . 'careers.html.php';
        $content = ob_get_clean();
        
        ob_start();
        include TEMPLATE_PATH . 'layout.html.php';
        return ob_get_clean();
    }
}