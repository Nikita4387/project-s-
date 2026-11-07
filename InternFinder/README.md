# InternFinder – Internship Opportunities Portal

A beginner-friendly college project built with **HTML5, CSS3, Bootstrap 5, JavaScript, Core PHP 8+, PDO and MySQL**. It includes student registration/login, database-driven internship search, applications and status tracking, plus a separate administrator panel.

## 1. Requirements
- XAMPP with Apache, MySQL and PHP 8.0+
- A browser and (optionally) Visual Studio Code
- Internet connection for Bootstrap and Font Awesome CDN assets

## 2. Run with XAMPP
1. Install and open XAMPP.
2. Start **Apache** and **MySQL**.
3. Extract the `InternFinder` folder into `C:\\xampp\\htdocs\\` (Windows).
4. Open `http://localhost/phpmyadmin/`.
5. Select **Import**, choose `InternFinder/database/internfinder_db.sql`, then click **Import**.
6. Open `InternFinder/config/database.php`. The default XAMPP values are host `localhost`, database `internfinder_db`, user `root`, and blank password. Change these if your MySQL setup differs.
7. Visit `http://localhost/InternFinder/`.

## 3. Demo administrator
- Login URL: `http://localhost/InternFinder/admin/login.php`
- Email: `admin@internfinder.local`
- Initial password: `Admin@12345`

The SQL file stores a PHP password hash, not the plain-text password. **Change the demo password immediately** before using this project beyond a local demonstration. To set a new password, create a one-time PHP file in the project root named `reset-admin.php` with the following code, run it once at `http://localhost/InternFinder/reset-admin.php`, then delete the file:

```php
<?php
require __DIR__ . '/config/database.php';
$email = 'admin@internfinder.local';
$newPassword = 'ChooseYourOwnStrongPassword';
$hash = password_hash($newPassword, PASSWORD_DEFAULT);
$stmt = $pdo->prepare('UPDATE admins SET password_hash = ? WHERE email = ?');
$stmt->execute([$hash, $email]);
echo 'Admin password updated. Delete this file now.';
```

Alternatively generate a hash with PHP `password_hash()` and update `admins.password_hash` in phpMyAdmin. Never store a plain-text password.

## 4. Test student features
1. Choose **Register** and create a student account with a valid email and password of at least 8 characters.
2. Log in from **Login**.
3. Open **Internships**, try title/company/skill search and category, location and paid/unpaid filters.
4. Open an internship detail page and click **Apply now**.
5. Confirm the application. A student can apply only once to each internship.
6. Open **My Applications** and verify the application status. The dashboard shows real counts from MySQL.
7. Log out using the navigation bar.

## 5. Test administrator features
1. Open the Admin login link at the bottom of the student login page, or visit `/InternFinder/admin/login.php`.
2. Sign in using the demo account above.
3. The dashboard shows student, internship and application counts.
4. Add an internship, then open **Manage internships** to view, edit or close it.
5. Open **Applications**, filter by internship or status, and change an application status.
6. Log in as the student again and verify the latest status in **My Applications**.
7. Closing an internship preserves existing applications but prevents new applications.

## 6. Main project structure
```text
InternFinder/
├── index.php, internships.php, internship-details.php, about.php, contact.php
├── config/database.php              # PDO connection
├── includes/                        # shared helpers, header, footer, card
├── student/                         # registration, login, dashboard, apply, history
├── admin/                           # admin login, dashboard, internship CRUD, applications
├── assets/css/style.css             # responsive theme
├── assets/js/script.js              # small client-side helpers
└── database/internfinder_db.sql     # schema and sample listings
```

## 7. Database tables
- `students`: student profile and password hash.
- `admins`: administrator accounts and password hash.
- `internships`: listing details, deadline, stipend and open/closed flag.
- `applications`: student-to-internship relationship, unique per pair, with status and timestamps.

Foreign keys enforce the relationships. PDO prepared statements are used for database operations. Passwords use `password_hash()` / `password_verify()`, sessions protect role-specific pages, forms use CSRF tokens, and output is escaped with `htmlspecialchars()`.

## 8. Notes and limitations
- The site is configured for the folder name `/InternFinder`. If you rename the folder, update the `/InternFinder` paths in the PHP includes, links and CSS/JS references.
- Bootstrap, Font Awesome and Google Fonts are loaded from CDNs; use an internet connection for those visual assets.
- The Contact page is informational and does not send email.
- This is an educational starter project. Before public deployment, add HTTPS, rate limiting, stronger operational logging, password reset, email verification, and production secrets management.
