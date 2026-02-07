---
description: Deploy code to thuetaikhoan.net
---

# Deploy to Production

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

5. Test: https://thuetaikhoan.net

---

## 📋 Thông Tin Quan Trọng

| Mục | Giá trị |
|-----|---------|
| **Production URL** | https://thuetaikhoan.net |
| **Admin URL** | https://thuetaikhoan.net/admin/login |
| **Admin Login** | admin / Tkk123@ |
| **Database** | `u620980434_thuetaikhoan` |

---

## 🔧 Nếu Gặp Lỗi

1. Check error: https://thuetaikhoan.net/fix-500.php
2. Check log: File Manager → `public_html/storage/logs/laravel.log`

---

## ⚠️ Lưu Ý

- Đây là Production, cẩn thận khi deploy!
- Timezone: Asia/Ho_Chi_Minh (UTC+7)
