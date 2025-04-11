CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    role TEXT NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP  NULL ,
    deleted_at TIMESTAMP  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS dreams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    amount BIGINT NOT NULL,
    image_path VARCHAR(255) DEFAULT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP  NULL ,
    deleted_at TIMESTAMP  NULL,
    fulfilled_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS admin_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    value TEXT NOT NULL,
   created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP  NULL ,
    deleted_at TIMESTAMP  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- add admins  with password is 'password'
INSERT INTO `users` (`id`, `username`, `role`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'sadmin', 'super-admin', '$2y$12$FqwpuQ1utkP2GKed6iOemO/qebvwFP7WirHUlxisUdnF1kNAI294u', current_timestamp(), NULL, NULL), (NULL, 'admin', 'admin', '$2y$12$FqwpuQ1utkP2GKed6iOemO/qebvwFP7WirHUlxisUdnF1kNAI294u', current_timestamp(), NULL, NULL);