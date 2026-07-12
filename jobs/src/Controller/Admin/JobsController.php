<?php
namespace Admin;

class JobsController {
    private $authentication;
    
    public function __construct($authentication) {
        $this->authentication = $authentication;
    }
    
    private function checkAuth() {
        if (!$this->authentication->isLoggedIn()) {
            header('Location: /admin/login');
            exit;
        }
    }
    
    private function isClient() {
        $user = $this->authentication->getUser();
        return $user && $user['role'] === 'client';
    }
    
    public function list() {
        $this->checkAuth();
        $pdo = getDB();
        
        $categoryFilter = isset($_GET['category']) ? (int)$_GET['category'] : 0;
        $sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'dateReceived';
        $sortDir = isset($_GET['dir']) && $_GET['dir'] === 'asc' ? 'ASC' : 'DESC';
        
        $sql = "SELECT job.*, category.name as category_name FROM job LEFT JOIN category ON category.id = job.categoryId";
        $params = [];
        
        if ($categoryFilter > 0) {
            $sql .= " WHERE job.categoryId = :categoryId";
            $params['categoryId'] = $categoryFilter;
        }
        
        if ($this->isClient()) {
            $user = $this->authentication->getUser();
            $sql .= ($categoryFilter > 0 ? " AND" : " WHERE") . " job.clientId = :clientId";
            $params['clientId'] = $user['id'];
        }
        
        $sql .= " ORDER BY job.$sortBy $sortDir";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $jobs = $stmt->fetchAll();
        
        $categoryTable = new \DatabaseTable($pdo, 'category', 'id');
        $allCategories = $categoryTable->findAll('name');
        $navCategories = $allCategories;
        
        $isClient = $this->isClient();
        $title = $isClient ? "My Jobs" : "Manage Jobs";
        
        ob_start();
        include TEMPLATE_PATH . 'admin_jobs.html.php';
        $content = ob_get_clean();
        
        ob_start();
        include TEMPLATE_PATH . 'layout.html.php';
        return ob_get_clean();
    }
    
    public function archive() {
        $this->checkAuth();
        $pdo = getDB();
        $id = $_POST['id'] ?? 0;
        
        if ($this->isClient()) {
            $user = $this->authentication->getUser();
            $stmt = $pdo->prepare("SELECT clientId FROM job WHERE id = ?");
            $stmt->execute([$id]);
            $job = $stmt->fetch();
            if ($job['clientId'] != $user['id']) {
                $_SESSION['error'] = 'You do not have permission to archive this job';
                header('Location: /admin/jobs');
                exit;
            }
        }
        
        $stmt = $pdo->prepare("UPDATE job SET archived = 1 WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['success'] = 'Job archived successfully';
        header('Location: /admin/jobs');
        exit;
    }
    
    public function unarchive() {
        $this->checkAuth();
        $pdo = getDB();
        $id = $_POST['id'] ?? 0;
        
        if ($this->isClient()) {
            $user = $this->authentication->getUser();
            $stmt = $pdo->prepare("SELECT clientId FROM job WHERE id = ?");
            $stmt->execute([$id]);
            $job = $stmt->fetch();
            if ($job['clientId'] != $user['id']) {
                $_SESSION['error'] = 'You do not have permission to unarchive this job';
                header('Location: /admin/jobs');
                exit;
            }
        }
        
        $stmt = $pdo->prepare("UPDATE job SET archived = 0 WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['success'] = 'Job unarchived successfully';
        header('Location: /admin/jobs');
        exit;
    }
    
    public function clientList() {
        $this->checkAuth();
        if (!$this->isClient()) {
            header('Location: /admin/jobs');
            exit;
        }
        return $this->list();
    }
    
    public function clientAdd() {
        $this->checkAuth();
        if (!$this->isClient()) {
            header('Location: /admin/jobs');
            exit;
        }
        
        $pdo = getDB();
        $user = $this->authentication->getUser();
        
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $salary = trim($_POST['salary'] ?? '');
        $closingDate = $_POST['closingDate'] ?? '';
        $categoryId = (int)($_POST['categoryId'] ?? 0);
        $location = trim($_POST['location'] ?? '');
        
        if (empty($title) || empty($description) || empty($salary) || empty($closingDate) || $categoryId === 0 || empty($location)) {
            $_SESSION['error'] = 'All fields are required';
            header('Location: /client/jobs');
            exit;
        }
        
        // FIXED: Changed to use CURDATE() for MySQL compatibility
        $stmt = $pdo->prepare("INSERT INTO job (title, description, salary, closingDate, categoryId, location, dateReceived, clientId) VALUES (?, ?, ?, ?, ?, ?, CURDATE(), ?)");
        $stmt->execute([$title, $description, $salary, $closingDate, $categoryId, $location, $user['id']]);
        
        $_SESSION['success'] = 'Job posted successfully';
        header('Location: /client/jobs');
        exit;
    }
    
    public function clientApplicants() {
        $this->checkAuth();
        if (!$this->isClient()) {
            header('Location: /admin/jobs');
            exit;
        }
        
        $pdo = getDB();
        $user = $this->authentication->getUser();
        $jobId = isset($_GET['jobId']) ? (int)$_GET['jobId'] : 0;
        
        $stmt = $pdo->prepare("SELECT title FROM job WHERE id = ? AND clientId = ?");
        $stmt->execute([$jobId, $user['id']]);
        $job = $stmt->fetch();
        
        if (!$job) {
            $_SESSION['error'] = 'Job not found or you do not have permission';
            header('Location: /client/jobs');
            exit;
        }
        
        $stmt = $pdo->prepare("
            SELECT a.*, t.status, t.notes, t.updatedAt 
            FROM applicants a 
            LEFT JOIN application_tracking t ON t.applicantId = a.id 
            WHERE a.jobId = ? 
            ORDER BY a.id DESC
        ");
        $stmt->execute([$jobId]);
        $applicants = $stmt->fetchAll();
        
        $categoryTable = new \DatabaseTable($pdo, 'category', 'id');
        $navCategories = $categoryTable->findAll('name');
        
        $title = "Applicants for " . htmlspecialchars($job['title']);
        
        ob_start();
        include TEMPLATE_PATH . 'client_applicants.html.php';
        $content = ob_get_clean();
        
        ob_start();
        include TEMPLATE_PATH . 'layout.html.php';
        return ob_get_clean();
    }
    
    public function applications() {
        $this->checkAuth();
        if ($this->isClient()) {
            header('Location: /client/jobs');
            exit;
        }
        
        $pdo = getDB();
        
        $stmt = $pdo->prepare("
            SELECT a.*, j.title as job_title, t.status, t.notes, t.updatedAt, t.id as trackingId
            FROM applicants a
            JOIN job j ON j.id = a.jobId
            LEFT JOIN application_tracking t ON t.applicantId = a.id
            ORDER BY a.id DESC
        ");
        $stmt->execute();
        $applications = $stmt->fetchAll();
        
        $categoryTable = new \DatabaseTable($pdo, 'category', 'id');
        $navCategories = $categoryTable->findAll('name');
        
        $title = "Application Tracking";
        
        ob_start();
        include TEMPLATE_PATH . 'admin_applications.html.php';
        $content = ob_get_clean();
        
        ob_start();
        include TEMPLATE_PATH . 'layout.html.php';
        return ob_get_clean();
    }
    
    public function updateApplication() {
        $this->checkAuth();
        if ($this->isClient()) {
            header('Location: /client/jobs');
            exit;
        }
        
        $pdo = getDB();
        $user = $this->authentication->getUser();
        
        $applicantId = $_POST['applicantId'] ?? 0;
        $status = $_POST['status'] ?? 'received';
        $notes = trim($_POST['notes'] ?? '');
        
        $allowedStatuses = ['received', 'reviewing', 'shortlisted', 'interviewed', 'offered', 'accepted', 'rejected', 'closed'];
        if (!in_array($status, $allowedStatuses)) {
            $status = 'received';
        }
        
        $stmt = $pdo->prepare("
            INSERT INTO application_tracking (applicantId, status, notes, updatedBy, createdAt, updatedAt) 
            VALUES (?, ?, ?, ?, NOW(), NOW())
            ON DUPLICATE KEY UPDATE status = ?, notes = ?, updatedBy = ?, updatedAt = NOW()
        ");
        $stmt->execute([$applicantId, $status, $notes, $user['id'], $status, $notes, $user['id']]);
        
        $_SESSION['success'] = 'Application status updated successfully';
        header('Location: /admin/applications');
        exit;
    }
}