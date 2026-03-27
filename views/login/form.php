<?php
// Logika autentikasi sudah diproses oleh controllers/login/login.php
// Variable $error_msg sudah tersedia dari controller
?>

<div class="col-lg-6 login-form-section">
    <div class="form-wrapper">
        <div class="brand-icon text-center mb-3">
            <img src="assets/img/logo.png" alt="Logo" width="100" height="100">
        </div>
        <h2 class="fw-bold text-dark mb-2">Masuk Akun</h2>
        <p class="text-muted mb-4">Silakan login</p>
    
        <?php if(!empty($error_msg)): ?>
        <div class="alert alert-danger d-flex align-items-center gap-2 border-0 shadow-sm p-3 mb-3 rounded-3" role="alert">
            <i data-lucide="alert-circle" style="width: 18px;"></i>
            <span class="small fw-bold"><?php echo $error_msg; ?></span>
        </div>
    <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label small fw-bold text-secondary">Username</label>
                <input type="text" class="form-control" name="user" required placeholder="Masukkan Username">
            </div>
            
            <div class="mb-3">  
                <label class="form-label small fw-bold text-secondary">Password</label>
                <input type="password" class="form-control" name="pwd" required placeholder="Masukkan Sandi">
            </div>

            <input type="submit" class="btn btn-primary w-100" value="Sign in" name="tombol" />
        </form>
    </div>
</div>