CREATE DATABASE IF NOT EXISTS internfinder_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE internfinder_db;

CREATE TABLE IF NOT EXISTS students (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 phone VARCHAR(20) NOT NULL,
 college VARCHAR(180) NOT NULL,
 course VARCHAR(120) NOT NULL,
 password_hash VARCHAR(255) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS admins (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS internships (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 title VARCHAR(180) NOT NULL,
 company VARCHAR(180) NOT NULL,
 category VARCHAR(100) NOT NULL,
 description TEXT NOT NULL,
 required_skills TEXT,
 responsibilities TEXT,
 eligibility TEXT,
 location VARCHAR(160) NOT NULL,
 work_mode ENUM('Remote','On-site','Hybrid') NOT NULL DEFAULT 'On-site',
 duration VARCHAR(80) NOT NULL,
 stipend DECIMAL(10,2) NOT NULL DEFAULT 0,
 is_paid TINYINT(1) NOT NULL DEFAULT 0,
 deadline DATE NOT NULL,
 is_open TINYINT(1) NOT NULL DEFAULT 1,
 created_by INT UNSIGNED NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 INDEX idx_open_deadline (is_open, deadline),
 INDEX idx_category (category),
 INDEX idx_title_company (title, company),
 CONSTRAINT fk_internship_admin FOREIGN KEY (created_by) REFERENCES admins(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS applications (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 student_id INT UNSIGNED NOT NULL,
 internship_id INT UNSIGNED NOT NULL,
 applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 status ENUM('Pending','Under Review','Shortlisted','Accepted','Rejected') NOT NULL DEFAULT 'Pending',
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 UNIQUE KEY uq_student_internship (student_id, internship_id),
 INDEX idx_application_status (status),
 INDEX idx_applied_at (applied_at),
 CONSTRAINT fk_application_student FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
 CONSTRAINT fk_application_internship FOREIGN KEY (internship_id) REFERENCES internships(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Demo administrator: admin@internfinder.local / Admin@12345
-- This is a PHP password_hash() bcrypt hash. Change it immediately after first login.
INSERT INTO admins(name,email,password_hash)
VALUES ('InternFinder Administrator','admin@internfinder.local','$2y$12$fmIqKs4V.tjEuOZLe2Qn2eGR0lF4pbN52M4uMQWKQ8LGhKf5bcilK')
ON DUPLICATE KEY UPDATE email=email;

INSERT INTO internships(title,company,category,description,required_skills,responsibilities,eligibility,location,work_mode,duration,stipend,is_paid,deadline)
VALUES
('Frontend Web Developer Intern','BrightWeb Technologies','Web Development','Work with the product team to build responsive web pages and improve user experience.','HTML, CSS, JavaScript, Bootstrap, Git','Build responsive UI components, test pages and collaborate with developers.','BE/BTech, BCA or related students with basic web development knowledge.','Pune, Maharashtra','Hybrid','3 months',8000,1,DATE_ADD(CURDATE(),INTERVAL 45 DAY)),
('PHP Developer Intern','CodeNest Solutions','Software Development','Assist in developing and maintaining PHP and MySQL web applications.','PHP, MySQL, HTML, CSS, JavaScript','Create modules, write SQL queries and fix application issues.','Students familiar with programming fundamentals and databases.','Remote','Remote','2 months',5000,1,DATE_ADD(CURDATE(),INTERVAL 60 DAY)),
('Digital Marketing Intern','GrowthSpark Media','Marketing','Support online campaigns, content planning and performance reporting.','Communication, SEO basics, social media','Prepare content calendars and analyze campaign metrics.','Any undergraduate student with an interest in digital marketing.','Nashik, Maharashtra','On-site','6 weeks',0,0,DATE_ADD(CURDATE(),INTERVAL 30 DAY)),
('IoT Project Intern','SmartEdge Labs','IoT','Assist with prototype development using microcontrollers and sensors.','Arduino, ESP32, C/C++, sensors','Test sensor modules, document results and support prototype integration.','Electronics, Computer or Electrical engineering students.','Remote','Remote','3 months',7000,1,DATE_ADD(CURDATE(),INTERVAL 75 DAY))
;
