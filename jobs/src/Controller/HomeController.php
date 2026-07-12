<?php
/**
 * HomeController - Handles the homepage with image-based banners
 */
class HomeController {
    private $authentication;
    
    public function __construct($authentication) {
        $this->authentication = $authentication;
    }
    
    public function home() {
        $pdo = getDB();
        
        // Get categories for display
        $categoryTable = new DatabaseTable($pdo, 'category', 'id');
        $categories = $categoryTable->findAll('name');
        $navCategories = $categories;
        
        // FIXED: Changed DATE('now') to CURDATE() for MySQL compatibility
        $jobTable = new DatabaseTable($pdo, 'job', 'id');
        $closingSoon = $jobTable->findAll('closingDate ASC', 'archived = 0 AND closingDate >= CURDATE()', [], 5);
        
        // Banners
        $banners = [
            [
                'title' => 'Find Your Dream Job',
                'subtitle' => 'Thousands of opportunities available in your area',
                'button_text' => 'Browse Jobs',
                'button_link' => '/jobs?id=1',
                'image' => '/images/banners/banner-1.jpg',
                'alt' => 'Find Your Dream Job Banner',
                'bg_color' => '#1a3a6e'
            ],
            [
                'title' => 'Top Employers Are Hiring',
                'subtitle' => 'Apply today and start your career journey',
                'button_text' => 'View Jobs',
                'button_link' => '/jobs?id=1',
                'image' => '/images/banners/banner-2.jpg',
                'alt' => 'Top Employers Banner',
                'bg_color' => '#2c3e50'
            ],
            [
                'title' => 'Career Advice Available',
                'subtitle' => 'Get tips to succeed in your job search',
                'button_text' => 'Read More',
                'button_link' => '/careers',
                'image' => '/images/banners/banner-3.jpg',
                'alt' => 'Career Advice Banner',
                'bg_color' => '#8e44ad'
            ],
            [
                'title' => 'Work With Top Companies',
                'subtitle' => 'Join leading employers in Northampton',
                'button_text' => 'Explore',
                'button_link' => '/jobs?id=2',
                'image' => '/images/banners/banner-4.jpg',
                'alt' => 'Top Companies Banner',
                'bg_color' => '#27ae60'
            ]
        ];
        
        $title = "Home";
        $auth = $this->authentication;
        
        ob_start();
        include TEMPLATE_PATH . 'home.html.php';
        $content = ob_get_clean();
        
        ob_start();
        include TEMPLATE_PATH . 'layout.html.php';
        return ob_get_clean();
    }
}