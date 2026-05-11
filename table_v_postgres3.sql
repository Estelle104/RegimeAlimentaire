CREATE TABLE adminUsers (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO adminUsers (username, password) VALUES
('admin', 'admin123'),
('superadmin', 'super456'),
('manager', 'manager789'),
('root', 'rootpassword'),
('andry', 'securepass');