<?php

    $user=$_POST['user']?? '';
    $pwd=$_POST['pwd'] ?? '';
    $tombol=$_POST['tombol'] ?? '';

    if($tombol){
            $_SESSION['status']='OKE';
            header('Location:index.php');
            exit;
        }
?>

<div class="col-lg-6 login-form-section">
            <div class="form-wrapper">
                <div class="brand-icon">
                    <i class="bi bi-hexagon-fill"></i>
                </div>
                <h2 class="fw-bold text-dark mb-2">Masuk ke Akun</h2>
                <p class="text-muted mb-4">Selamat datang kembali! Silakan masukkan detail Anda.</p>

                <form method="post">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">username</label>
                        <input type="text" class="form-control" placeholder="username" name="user">
                    </div>
                    
                    <div class="mb-3">  
                            <label class="form-label small fw-bold text-secondary">Password</label>
                        <input type="password" class="form-control" placeholder="minimal 8 karakter" name="pwd">
                    </div>

                    <input type="submit" class="btn btn-login w-100" value="Sign in" name="tombol" />
                </form>
            </div>
</div>