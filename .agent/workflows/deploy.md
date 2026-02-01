---
description: Deploy code to staging.thuetaikhoan.net
---

# Deploy to Staging

## 🚀 Quick Deploy (Auto - 30 giây)

Auto-deploy đã bật! Chỉ cần push là xong.

// turbo-all

1. Stage all changes:
```bash
git add .
```

2. Commit with message:
```bash
git commit -m "Your commit message"
```

3. Push to GitHub (auto deploy):
```bash
git push origin main
```

4. **Done!** Hostinger sẽ tự động deploy trong 30 giây.

5. Test: https://staging.thuetaikhoan.net

---

## 📋 Thông Tin Quan Trọng

| Mục | Giá trị |
|-----|---------|
| **Staging URL** | https://staging.thuetaikhoan.net |
| **Admin URL** | https://staging.thuetaikhoan.net/admin/login |
| **Admin Login** | admin / Tkk123@ |
| **Git Directory** | `staging` |
| **Database** | `u620980434_thuetaikhoan` (chung với production) |

---

## 🔧 Nếu Gặp Lỗi

1. Check error: https://staging.thuetaikhoan.net/fix-500.php
2. Check log: File Manager → `staging/storage/logs/laravel.log`
3. Reset admin: https://staging.thuetaikhoan.net/fix-admin.php

---

## ⚠️ Lưu Ý

- Database dùng chung với Production!
- Timezone: Asia/Ho_Chi_Minh (UTC+7)
