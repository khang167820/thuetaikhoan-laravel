<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ThueTaiKhoan.vn</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .login-container {
        width: 100%;
        max-width: 400px;
    }
    
    .login-card {
        background: #1e293b;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 25px 50px rgba(0,0,0,0.3);
        border: 1px solid #334155;
    }
    
    .login-logo {
        text-align: center;
        margin-bottom: 32px;
    }
    .login-logo img {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        margin-bottom: 16px;
    }
    .login-logo h1 {
        color: #f1f5f9;
        font-size: 22px;
        font-weight: 700;
    }
    .login-logo p {
        color: #64748b;
        font-size: 13px;
        margin-top: 4px;
    }
    
    .alert {
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 13px;
    }
    .alert-error {
        background: rgba(220, 38, 38, 0.15);
        color: #ef4444;
        border: 1px solid rgba(220, 38, 38, 0.3);
    }
    .alert-success {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        display: block;
        color: #94a3b8;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .form-input {
        width: 100%;
        padding: 14px 16px;
        background: #0f172a;
        border: 2px solid #334155;
        border-radius: 12px;
        color: #f1f5f9;
        font-size: 14px;
        transition: all 0.2s;
    }
    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
    .form-input::placeholder {
        color: #475569;
    }
    
    .login-btn {
        width: 100%;
        padding: 14px 24px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border: none;
        border-radius: 12px;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        margin-top: 8px;
    }
    .login-btn:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
    }
    
    .login-footer {
        text-align: center;
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid #334155;
    }
    .login-footer a {
        color: #64748b;
        font-size: 13px;
        text-decoration: none;
        transition: color 0.2s;
    }
    .login-footer a:hover {
        color: #3b82f6;
    }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">
                <img src="/assets/images/logo.png" alt="Logo">
                <h1>Admin Panel</h1>
                <p>ThueTaiKhoan.vn</p>
            </div>
            
            <?php if($errors->any()): ?>
                <div class="alert alert-error">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($error); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
            
            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            
            <?php if(session('error')): ?>
                <div class="alert alert-error"><?php echo e(session('error')); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo e(route('admin.login.submit')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label class="form-label">Tên đăng nhập</label>
                    <input type="text" name="username" class="form-input" placeholder="admin" value="<?php echo e(old('username')); ?>" required autofocus>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                </div>
                
                <button type="submit" class="login-btn">
                    Đăng nhập
                </button>
            </form>
            
            <div class="login-footer">
                <a href="/">← Về trang chủ</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/admin/login.blade.php ENDPATH**/ ?>