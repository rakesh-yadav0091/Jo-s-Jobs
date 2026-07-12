<?php

use Framework\RoutesInterface;

class Routes implements RoutesInterface {
    public function getControllerAndMethod($route, $method) {
        // ===== ADMIN ROUTES =====
        if ($route === "admin/login") {
            return ["Admin\LoginController", "loginForm"];
        }
        if ($route === "admin/logout") {
            return ["Admin\LoginController", "logout"];
        }
        if ($route === "admin/jobs") {
            return ["Admin\JobsController", "list"];
        }
        if ($route === "admin/jobs/archive" && $method === "POST") {
            return ["Admin\JobsController", "archive"];
        }
        if ($route === "admin/jobs/unarchive" && $method === "POST") {
            return ["Admin\JobsController", "unarchive"];
        }
        if ($route === "admin/users") {
            return ["Admin\UsersController", "list"];
        }
        if ($route === "admin/users/add" && $method === "POST") {
            return ["Admin\UsersController", "add"];
        }
        if ($route === "admin/users/delete" && $method === "POST") {
            return ["Admin\UsersController", "delete"];
        }
        if ($route === "admin/enquiries") {
            return ["Admin\EnquiriesController", "list"];
        }
        if ($route === "admin/enquiries/complete" && $method === "POST") {
            return ["Admin\EnquiriesController", "complete"];
        }
        if ($route === "admin/applications") {
            return ["Admin\JobsController", "applications"];
        }
        if ($route === "admin/applications/update" && $method === "POST") {
            return ["Admin\JobsController", "updateApplication"];
        }
        
        // ===== CLIENT ROUTES =====
        if ($route === "client/jobs") {
            return ["Admin\JobsController", "clientList"];
        }
        if ($route === "client/jobs/add" && $method === "POST") {
            return ["Admin\JobsController", "clientAdd"];
        }
        if ($route === "client/applicants") {
            return ["Admin\JobsController", "clientApplicants"];
        }
        
        // ===== ALERT ROUTES =====
        if ($route === "alert/subscribe") {
            return ["AlertController", "subscribeForm"];
        }
        if ($route === "alert/subscribe" && $method === "POST") {
            return ["AlertController", "subscribe"];
        }
        if ($route === "alert/unsubscribe") {
            return ["AlertController", "unsubscribe"];
        }
        
        // ===== SAVED JOBS ROUTES =====
        if ($route === "jobs/save" && $method === "POST") {
            return ["JobsController", "saveJob"];
        }
        if ($route === "jobs/saved") {
            return ["JobsController", "savedJobs"];
        }
        
        // ===== FRONTEND ROUTES =====
        if ($route === "about") {
            return ["AboutController", "about"];
        }
        if ($route === "careers") {
            return ["CareersController", "advice"];
        }
        if ($route === "contact") {
            return ["ContactController", "contact"];
        }
        if ($route === "apply" && $method === "GET") {
            return ["ApplyController", "showForm"];
        }
        if ($route === "apply" && $method === "POST") {
            return ["ApplyController", "submit"];
        }
        if ($route === "jobs") {
            return ["JobsController", "list"];
        }
        
        // ===== DEFAULT =====
        return ["HomeController", "home"];
    }
}
