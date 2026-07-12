<div class="contact-container">
    <h2>Contact Us</h2>
    
    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="contact-info">
        <div class="info-box">
            <i class="fas fa-phone"></i>
            <h3>Phone</h3>
            <p>01604 123456</p>
        </div>
        <div class="info-box">
            <i class="fas fa-envelope"></i>
            <h3>Email</h3>
            <p>info@josjobs.co.uk</p>
        </div>
        <div class="info-box">
            <i class="fas fa-map-marker-alt"></i>
            <h3>Address</h3>
            <p>123 High Street, Heartfordshire, NN1 1AA</p>
        </div>
    </div>
    
    <div class="contact-form-wrapper">
        <h3>Send us a Message</h3>
        <form method="POST" action="/contact" class="contact-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="firstName">First Name *</label>
                    <input type="text" id="firstName" name="firstName" required>
                </div>
                <div class="form-group">
                    <label for="surname">Surname *</label>
                    <input type="text" id="surname" name="surname" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="telephone">Telephone</label>
                    <input type="tel" id="telephone" name="telephone">
                </div>
            </div>
            <div class="form-group">
                <label for="enquiry">Enquiry *</label>
                <textarea id="enquiry" name="enquiry" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn-submit">Send Enquiry</button>
        </form>
    </div>
</div>

<style>
.contact-container { max-width: 1000px; margin: 0 auto; padding: 30px; }
.contact-info { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; margin: 30px 0; }
.info-box { text-align: center; padding: 30px; background: #f8f9fa; border-radius: 15px; }
.info-box i { font-size: 40px; color: #1a3a6e; }
.info-box h3 { margin: 10px 0; color: #1a3a6e; }
.contact-form-wrapper { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-top: 30px; }
.contact-form .form-row { display: flex; gap: 20px; flex-wrap: wrap; }
.contact-form .form-group { flex: 1; min-width: 200px; margin-bottom: 20px; }
.contact-form .form-group label { display: block; font-weight: 600; margin-bottom: 5px; }
.contact-form .form-group input, .contact-form .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
.btn-submit { background: linear-gradient(135deg, #1a3a6e, #c0392b); color: white; padding: 15px 40px; border: none; border-radius: 30px; font-size: 16px; cursor: pointer; z-index: 10; position: relative; }
.btn-submit:hover { transform: scale(1.05); }
</style>