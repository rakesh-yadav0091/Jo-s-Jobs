<?php
class ApplyController {
    private $authentication;
    
    public function __construct($authentication) {
        $this->authentication = $authentication;
    }
    
    public function showForm() {
        $jobId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $pdo = getDB();
        
        $jobTable = new DatabaseTable($pdo, 'job', 'id');
        $job = $jobTable->findById($jobId);
        
        if (!$job || $job['archived'] || $job['closingDate'] < date('Y-m-d')) {
            header('Location: /jobs?id=1');
            exit;
        }
        
        $categoryTable = new DatabaseTable($pdo, 'category', 'id');
        $categories = $categoryTable->findAll('name');
        $navCategories = $categories;
        
        $title = "Apply for " . htmlspecialchars($job['title']);
        $auth = $this->authentication;
        
        ob_start();
        include TEMPLATE_PATH . 'apply.html.php';
        $content = ob_get_clean();
        
        ob_start();
        include TEMPLATE_PATH . 'layout.html.php';
        return ob_get_clean();
    }
    
    public function submit() {
        $pdo = getDB();
        $error = '';
        $message = '';
        
        $jobId = (int)($_POST['jobId'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $details = trim($_POST['details'] ?? '');
        
        if (empty($name)) {
            $error = 'Please enter your name.';
        } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } elseif (empty($details)) {
            $error = 'Please provide your cover letter.';
        } elseif (!isset($_FILES['cv']) || $_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
            $error = 'Please upload your CV.';
        } else {
            $ext = strtolower(pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION));
            $allowed = ['pdf', 'doc', 'docx'];
            if (!in_array($ext, $allowed)) {
                $error = 'Please upload a PDF or Word document.';
            } else {
                $uploadDir = __DIR__ . '/../../public/cvs';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $filename = 'cv_' . uniqid() . '.' . $ext;
                $filePath = $uploadDir . '/' . $filename;
                
                if (move_uploaded_file($_FILES['cv']['tmp_name'], $filePath)) {
                    $stmt = $pdo->prepare("INSERT INTO applicants (name, email, details, jobId, cv) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$name, $email, $details, $jobId, $filename]);
                    
                    // Add application tracking
                    $applicantId = $pdo->lastInsertId();
                    $stmt = $pdo->prepare("INSERT INTO application_tracking (applicantId, status, createdAt) VALUES (?, 'received', NOW())");
                    $stmt->execute([$applicantId]);
                    
                    $message = 'Thank you for your application. We will contact you after the closing date.';
                } else {
                    $error = 'Failed to upload CV. Please try again.';
                }
            }
        }
        
        if ($error) {
            $_SESSION['error'] = $error;
            header('Location: /apply?id=' . $jobId);
            exit;
        }
        
        $jobTable = new DatabaseTable($pdo, 'job', 'id');
        $job = $jobTable->findById($jobId);
        $title = "Application Submitted";
        
        ob_start();
        include TEMPLATE_PATH . 'apply_success.html.php';
        $content = ob_get_clean();
        
        ob_start();
        include TEMPLATE_PATH . 'layout.html.php';
        return ob_get_clean();
    }
}