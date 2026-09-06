USE talabat;

ALTER TABLE coupons
ADD COLUMN usage_count INT NOT NULL DEFAULT 0;