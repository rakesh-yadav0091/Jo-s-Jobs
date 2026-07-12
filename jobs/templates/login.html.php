<div class="login-container">
    <div class="login-box">
        <div class="login-header">
            <div class="login-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h2>Admin Login</h2>
            <p class="login-subtitle">Enter your credentials to access the dashboard</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="/admin/login" class="login-form">
            <div class="form-group">
                <label for="username">
                    <i class="fas fa-user"></i> Username
                </label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">
                    <i class="fas fa-key"></i> Password
                </label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
        
        <div class="login-footer">
            <p>Secure access to the Jo's Jobs administration area.</p>
            <p class="help-text">Need help? Contact your system administrator.</p>
        </div>
    </div>
</div>

<style>
/* Login Page Styles */
.login-container {
    max-width: 420px;
    margin: 60px auto;
    padding: 20px;
}

.login-box {
    background: white;
    border-radius: 20px;
    padding: 40px 35px;
    box-shadow: 0 10px 50px rgba(0,0,0,0.15);
}

.login-header {
    text-align: center;
    margin-bottom: 30px;
}

.login-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #1a3a6e, #c0392b);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    color: white;
    font-size: 30px;
}

.login-header h2 {
    color: #1a3a6e;
    font-size: 28px;
    margin-bottom: 5px;
}

.login-subtitle {
    color: #888;
    font-size: 14px;
}

/* Form Styles */
.login-form .form-group {
    margin-bottom: 20px;
}

.login-form .form-group label {
    display: block;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    font-size: 14px;
}

.login-form .form-group label i {
    color: #1a3a6e;
    margin-right: 8px;
}

.login-form .form-group input {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-size: 15px;
    transition: border-color 0.3s ease;
    background: #fafafa;
}

.login-form .form-group input:focus {
    outline: none;
    border-color: #1a3a6e;
    background: white;
    box-shadow: 0 0 0 4px rgba(26, 58, 110, 0.1);
}

.login-form .form-group input::placeholder {
    color: #bbb;
}

/* Login Button */
.btn-login {
    width: 100%;
    background: linear-gradient(135deg, #1a3a6e, #c0392b);
    color: white;
    padding: 14px;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 10px;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(192, 57, 43, 0.3);
}

.btn-login:active {
    transform: translateY(0);
}

/* Footer */
.login-footer {
    margin-top: 25px;
    text-align: center;
    border-top: 1px solid #f0f0f0;
    padding-top: 20px;
}

.login-footer p {
    color: #999;
    font-size: 13px;
    margin: 5px 0;
}

.login-footer .help-text {
    color: #bbb;
    font-size: 12px;
}

/* Alert Messages */
.alert {
    padding: 12px 18px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
}

.alert-error {
    background: #fde8e8;
    color: #c0392b;
    border: 1px solid #f5c6cb;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert i {
    font-size: 18px;
}

/* Responsive */
@media (max-width: 480px) {
    .login-container {
        padding: 10px;
        margin: 30px auto;
    }
    
    .login-box {
        padding: 25px 20px;
    }
    
    .login-header h2 {
        font-size: 24px;
    }
    
    .login-icon {
        width: 60px;
        height: 60px;
        font-size: 24px;
    }
}
</style>