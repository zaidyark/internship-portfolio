<?php
// includes/config.php
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'internship_portfolio');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    // Set charset
    $conn->set_charset("utf8");

    // Create tables if they don't exist
    $sql = "CREATE TABLE IF NOT EXISTS contacts (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                    subject VARCHAR(255),
                        message TEXT,
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                            )";

                            $conn->query($sql);

                            $sql = "CREATE TABLE IF NOT EXISTS admin_users (
                                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                    username VARCHAR(50) NOT NULL UNIQUE,
                                        password VARCHAR(255) NOT NULL,
                                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                                            )";

                                            $conn->query($sql);

                                            $sql = "CREATE TABLE IF NOT EXISTS members (
                                                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                                    student_id VARCHAR(20) NOT NULL UNIQUE,
                                                        full_name VARCHAR(100) NOT NULL,
                                                            email VARCHAR(100) NOT NULL UNIQUE,
                                                                phone VARCHAR(20),
                                                                    course VARCHAR(100),
                                                                        year_of_study INT,
                                                                            password VARCHAR(255) NOT NULL,
                                                                                profile_image VARCHAR(255),
                                                                                    is_verified BOOLEAN DEFAULT FALSE,
                                                                                        verification_token VARCHAR(100),
                                                                                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                                                                                            )";

                                                                                            $conn->query($sql);

                                                                                            $sql = "CREATE TABLE IF NOT EXISTS member_profiles (
                                                                                                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                                                                                    member_id INT(6) UNSIGNED,
                                                                                                        bio TEXT,
                                                                                                            skills TEXT,
                                                                                                                achievements TEXT,
                                                                                                                    social_links TEXT,
                                                                                                                        FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
                                                                                                                        )";

                                                                                                                        $conn->query($sql);

                                                                                                                        // Insert default admin user if not exists (username: admin, password: admin123)
                                                                                                                        $check_admin = $conn->query("SELECT * FROM admin_users WHERE username='admin'");
                                                                                                                        if ($check_admin->num_rows == 0) {
                                                                                                                            $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
                                                                                                                                $conn->query("INSERT INTO admin_users (username, password) VALUES ('admin', '$hashed_password')");
                                                                                                                                }

                                                                                                                                // Function to check if user is logged in
                                                                                                                                function isLoggedIn() {
                                                                                                                                    return isset($_SESSION['member_id']);
                                                                                                                                    }

                                                                                                                                    // Function to get current user data
                                                                                                                                    function getCurrentUser() {
                                                                                                                                        global $conn;
                                                                                                                                            if (isset($_SESSION['member_id'])) {
                                                                                                                                                    $user_id = $_SESSION['member_id'];
                                                                                                                                                            $result = $conn->query("SELECT * FROM members WHERE id = $user_id");
                                                                                                                                                                    return $result->fetch_assoc();
                                                                                                                                                                        }
                                                                                                                                                                            return null;
                                                                                                                                                                            }
                                                                                                                                                                            ?>