---
description: Deploy code to staging.thuetaikhoan.net
---

# Deploy to Staging

## Quick Deploy (2 minutes)

// turbo-all

1. Stage all changes:
```bash
git add .
```

2. Commit with message:
```bash
git commit -m "Your commit message"
```

3. Push to GitHub:
```bash
git push origin main
```

4. **Manual step:** Go to hPanel → Advanced → GIT → Click **Deploy**

5. Test: https://staging.thuetaikhoan.net

## If Something Breaks

1. Check error at: https://staging.thuetaikhoan.net/fix-500.php (if exists)
2. Or check File Manager → `staging/storage/logs/laravel.log`

## Important Paths

- **Git Directory:** `staging` (in hPanel)
- **Subdomain points to:** `staging/public`
- **Database:** `u620980434_thuetaikhoan` (shared with production)
