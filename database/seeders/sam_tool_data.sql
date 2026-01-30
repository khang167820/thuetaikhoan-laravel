-- Thêm gói giá cho Samsung Tool
INSERT INTO `prices` (`hours`, `price`, `original_price`, `discount_percent`, `promo_label`, `promo_badge`, `created_at`, `type`) VALUES
(6, 95000, 120000, 21, 'Tiết kiệm', 'Khuyến mãi', NOW(), 'SamsungTool'),
(12, 120000, 150000, 20, 'Phổ biến', 'HOT', NOW(), 'SamsungTool'),
(24, 150000, 200000, 25, 'Tiết kiệm nhất', 'Flash Sale', NOW(), 'SamsungTool');
-- Note: Gói 48h đã có trong database với id=41, price=180000

-- Thêm tài khoản test cho Samsung Tool (nếu chưa có)
INSERT INTO `accounts` (`type`, `username`, `password`, `is_available`, `created_at`) VALUES
('SamsungTool', 'samsungtool_demo1', 'demo_password_123', 1, NOW()),
('SamsungTool', 'samsungtool_demo2', 'demo_password_456', 1, NOW());
