# Database Schema Reference

> **Database**: `u620980434_thuetaikhoan` (MariaDB)
> **Last updated**: 2026-02-07

## Tables (15 total)

### accounts
Tài khoản dịch vụ cho thuê (UnlockTool, Vietmap, KG Killer, ...).

| Column           | Type                  | Default              | Note                       |
|------------------|-----------------------|----------------------|----------------------------|
| `id`             | int(11) PK AI         |                      |                            |
| `username`       | varchar(255) NOT NULL |                      |                            |
| `password`       | varchar(255) NOT NULL |                      |                            |
| `type`           | varchar(100) NOT NULL | `'Unlocktool'`       | Loại dịch vụ (xem bảng dưới) |
| `is_available`   | tinyint(1) NOT NULL   | `1`                  | 1 = còn, 0 = đang cho thuê |
| `note`           | text                  | NULL                 | Ghi chú admin              |
| `note_date`      | date                  | NULL                 |                            |
| `password_changed` | tinyint(1) NOT NULL | `0`                  | Khách đổi mật khẩu?       |
| `created_at`     | datetime NOT NULL     | `current_timestamp()`|                            |

#### Service Type Mapping (accounts.type / prices.type / orders.service_type)

| DB Type Value   | Display Name          | Route Slug           | ServiceController Key |
|-----------------|-----------------------|----------------------|-----------------------|
| `Unlocktool`    | UnlockTool            | `/thue-unlocktool`   | `Unlocktool`          |
| `Vietmap`       | Vietmap Live (PRO)    | `/thue-vietmap`      | `Vietmap`             |
| `TSMTool`       | TSM Tool              | `/thue-tsm`          | `TSMTool`             |
| `Griffin`       | Griffin-Unlocker      | `/thue-griffin`      | `Griffin`             |
| `AMT`           | Android Multitool     | `/thue-amt`          | `AMT`                 |
| `KGKiller`      | KG Killer Tool        | `/thue-kg-killer`    | `KGKiller`            |
| `DFTPro`        | DFT Pro Tool          | `/thue-dft`          | `DFTPro`              |
| `SamsungTool`   | Samsung Tool          | `/thue-samsung-tool` | `SamsungTool`         |

> ⚠️ **QUAN TRỌNG**: Type value phải KHỚP giữa `accounts.type`, `prices.type`, `orders.service_type`,
> `ServiceController::$services` array key, `web.php` `$serviceTypes`, `AdminController::$allowedTypes`,
> `CheckoutController` slug mapping, và `welcome.blade.php` `$availableServices`.

---

### admins
Admin đăng nhập quản trị.

| Column      | Type                  | Default              |
|-------------|-----------------------|----------------------|
| `id`        | int(11) PK AI         |                      |
| `username`  | varchar(255) NOT NULL |                      |
| `password`  | varchar(255) NOT NULL |                      |
| `created_at`| timestamp             | `current_timestamp()`|

---

### orders
Đơn hàng thuê tài khoản.

| Column           | Type                  | Default              | Note                  |
|------------------|-----------------------|----------------------|-----------------------|
| `id`             | int(11) PK AI         |                      |                       |
| `user_id`        | int(11)               | NULL                 |                       |
| `user_email`     | varchar(255)          | NULL                 |                       |
| `user_phone`     | varchar(20)           | NULL                 |                       |
| `user_name`      | varchar(255)          | NULL                 |                       |
| `coupon_code`    | varchar(50)           | NULL                 |                       |
| `coupon_discount`| int(11)               | `0`                  |                       |
| `account_id`     | int(11)               | NULL                 | FK → accounts.id      |
| `service_type`   | varchar(100)          | NULL                 | Khớp với accounts.type|
| `order_code`     | varchar(20) NOT NULL  |                      | Mã đơn (DH????)      |
| `hours`          | int(11) NOT NULL      |                      | Số giờ thuê           |
| `price`          | int(11) NOT NULL      |                      | Giá (VND)             |
| `discount`       | int(11)               | `0`                  |                       |
| `points_used`    | int(11)               | `0`                  |                       |
| `status`         | varchar(20)           | `'pending'`          | pending/paid/expired/cancelled |
| `ip_address`     | varchar(45)           | NULL                 |                       |
| `paid_at`        | datetime              | NULL                 |                       |
| `expires_at`     | datetime              | NULL                 | Thời gian hết hạn     |
| `created_at`     | datetime              | `current_timestamp()`|                       |
| `momo_request_id`| varchar(100)          | NULL                 |                       |
| `transaction_id` | varchar(100)          | NULL                 |                       |
| `payment_method` | varchar(50)           | NULL                 |                       |
| `payment_url`    | text                  | NULL                 |                       |
| `momo_order_id`  | varchar(100)          | NULL                 |                       |
| `original_price` | int(11)               | NULL                 |                       |
| `promo_label`    | varchar(100)          | NULL                 |                       |
| `affiliate_code` | varchar(50)           | NULL                 |                       |
| `affiliate_commission`| int(11)          | NULL                 |                       |
| `points_earned`  | int(11)               | `0`                  |                       |

---

### prices
Bảng giá các gói thuê.

| Column            | Type                  | Default              |
|-------------------|-----------------------|----------------------|
| `id`              | int(11) PK AI         |                      |
| `hours`           | int(11) NOT NULL      |                      |
| `price`           | int(11) NOT NULL      |                      |
| `original_price`  | int(11)               | NULL                 |
| `discount_percent`| int(11)               | `0`                  |
| `promo_label`     | varchar(100)          | NULL                 |
| `promo_badge`     | varchar(50)           | NULL                 |
| `promo_start`     | datetime              | NULL                 |
| `promo_end`       | datetime              | NULL                 |
| `created_at`      | datetime              | `current_timestamp()`|
| `type`            | varchar(100) NOT NULL |                      |

---

### users
Khách hàng đăng ký.

| Column      | Type                  | Default              |
|-------------|-----------------------|----------------------|
| `id`        | int(11) PK AI         |                      |
| `name`      | varchar(255) NOT NULL |                      |
| `email`     | varchar(255) UNIQUE   |                      |
| `phone`     | varchar(20)           | NULL                 |
| `password`  | varchar(255) NOT NULL |                      |
| `balance`   | bigint(20)            | `0`                  |
| `points`    | int(11)               | `0`                  |
| `affiliate_code` | varchar(50) UNIQUE| NULL                 |
| `referred_by`| varchar(50)          | NULL                 |
| `created_at`| timestamp             | `current_timestamp()`|

---

### coupons
Mã giảm giá.

| Column              | Type                           | Default     |
|---------------------|--------------------------------|-------------|
| `id`                | int(11) PK AI                  |             |
| `code`              | varchar(50) NOT NULL           |             |
| `discount_type`     | enum('percent','fixed')        | `'fixed'`   |
| `discount_value`    | int(11) NOT NULL               | `0`         |
| `min_order_amount`  | int(11)                        | `0`         |
| `max_uses`          | int(11)                        | `0`         |
| `used_count`        | int(11)                        | `0`         |
| `expires_at`        | datetime                       | NULL        |
| `is_active`         | tinyint(1)                     | `1`         |
| `created_at`        | timestamp                      | `current_timestamp()` |
| `max_discount_amount`| int(11)                       | `0`         |

---

### deposits
Nạp tiền vào tài khoản.

| Column          | Type                                    | Default     |
|-----------------|-----------------------------------------|-------------|
| `id`            | int(11) PK AI                           |             |
| `user_id`       | int(11) NOT NULL                        |             |
| `amount`        | bigint(20) NOT NULL                     |             |
| `method`        | varchar(50)                             | `'bank'`    |
| `transaction_id`| varchar(100)                            | NULL        |
| `status`        | enum('pending','completed','failed')    | `'pending'` |
| `created_at`    | datetime                                | `current_timestamp()` |
| `completed_at`  | datetime                                | NULL        |
| `note`          | text                                    | NULL        |

---

### balance_history
Lịch sử biến động số dư.

| Column      | Type            | Default              |
|-------------|-----------------|----------------------|
| `id`        | int(11) PK AI   |                      |
| `user_id`   | int(11) NOT NULL|                      |
| `amount`    | bigint(20) NOT NULL |                  |
| `type`      | varchar(50) NOT NULL |                 |
| `description`| text           | NULL                 |
| `reference_id`| int(11)       | NULL                 |
| `created_at`| datetime        | `current_timestamp()`|

---

### blog_posts / blog_categories
Blog và danh mục blog (SEO content).

---

### ady_orders
Đơn hàng từ hệ thống ADY (dịch vụ bên thứ ba).

---

### settings
Cấu hình hệ thống (key-value).

| Column  | Type                  |
|---------|-----------------------|
| `key`   | varchar(255) PK       |
| `value` | longtext              |

---

### sessions / cache / cache_locks
Laravel framework tables (session, cache management).

---

## Removed Tables (không còn dùng)
- `admin` → thay bằng `admins`
- `ady_product_mapping` → không dùng
- `ip_rate_limits` → không dùng
- `migrations` → không cần (manual DB)

## Removed Columns từ accounts
- `available_since` → không dùng
- `renewal_date` → không dùng
- `status` → không dùng (dùng `is_available` thay thế)
