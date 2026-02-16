CREATE DATABASE IF NOT EXISTS task_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE task_manager;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nickname VARCHAR(50) NOT NULL,
    name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    type ENUM('Admin','Member') DEFAULT 'Member',
    creation_date DATE
); 

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    color VARCHAR(50) NOT NULL
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    state ENUM('pending','inProgress','completed') DEFAULT 'pending',
    start_date DATE,
    start_time TIME,
    end_time TIME,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
); 

INSERT INTO users (nickname, name, surname, password, email, type, creation_date) VALUES
('raven', 'ravenc0loud', 'surname', 'pass1', 'raven@example.com', 'Admin', '2026-02-16'),
('Elena', 'Elena', 'surname', 'pass2', 'elena@example.com', 'Member', '2026-02-16');

INSERT INTO categories (name, description, color) VALUES
('Work', 'Tasks related to work', 'blue-500'),
('Personal', 'Personal tasks and errands', 'teal-500'),
('Hobbies', 'Tasks related to hobbies and leisure activities', 'red-500');

INSERT INTO tasks (name, description, state, start_date, start_time, end_time, user_id, category_id) VALUES
('Finish project report', 'Complete the final report for the project', 'pending', '2026-02-17', '09:00:00', '11:00:00', 1, 1),
('Grocery shopping', 'Buy groceries for the week', 'inProgress', '2026-02-17', '12:00:00', '13:00:00', 2, 2),
('Practice guitar', 'Spend time practicing guitar chords and songs', 'completed', '2026-02-16', '18:00:00', '19:30:00', 1, 3);