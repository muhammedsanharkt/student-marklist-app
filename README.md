# student-marklist-app

A simple PHP + MySQL web application to manage student marks. Features include adding student details, viewing all records, individual marklists with total and average, and a responsive Bootstrap UI.

The School Management System is a web-based application designed to simplify the process of managing student records, especially their academic results. This system allows for secure role-based access, ensuring that only authorized users can perform specific actions. The platform is developed using PHP, MySQL, and Bootstrap for a responsive and user-friendly interface.

💡 Key Features:
User Registration & Login:

Secure user registration with hashed passwords.

Role-based login redirecting:

Admins access the admin dashboard (adminpage.php).

Students/Users access the user homepage (userhome.php).

Admin Functionalities:

Add, edit, and delete student marks.

View overall rankings, subject-wise results, and individual student performances.

Dashboard access with all result management features.

User Functionalities:

View personal results securely.

Access homepage with school information and contact details.

Security:

Passwords stored using bcrypt hashing.

Form validation (client + server-side) to prevent empty or invalid submissions.

Sessions for user authentication and access control.

Frontend:

Clean, mobile-responsive design using Bootstrap 5.

Navigation bar with login, registration, and page links.

🛠️ Technologies Used:
Frontend: HTML, CSS, Bootstrap

Backend: PHP (with procedural MySQLi)

Database: MySQL

Security: Password Hashing (password_hash and password_verify), Session Management

Extras: AJAX (for future enhancements), Form validation, Alert fading effects, Role redirection logic

