# TrackStorm
Task Management System in PHP and MySQL

The Task Management System in PHP and MySQL is a robust and user-friendly solution designed to empower organizations to efficiently oversee project task progress. With distinct user roles – Admin, Project Manager, and Regular Employee – the system provides tailored functionalities to suit the hierarchical needs of organizations.

Features

1. Admin Role

Create and manage user accounts for the Task Management System.
Assign roles to users (Admin, Project Manager, or Regular Employee).

2. Project Manager Role

Create and manage projects with essential details.
Assign employees to specific projects and tasks.
Review and monitor employee work progress.
Update task statuses based on completion.

3. Regular Employee Role

Add work progress updates for assigned projects.
Edit their own submitted progress data.
View project and task details assigned to them.

How It Works

User Setup:
Admins create user accounts and assign roles.

Project Creation:
Admins or Project Managers create new projects with necessary details and assign employees to handle specific tasks.

Task Progress Updates:
Regular Employees update their task progress in the system.
Employees can edit only the progress they submitted.

Task Review:
Project Managers review employee progress and update task statuses as completed or in-progress.

Installation Instructions

System Requirements:
PHP 7.4 or higher
MySQL 5.7 or higher
A web server (e.g., Apache or Nginx)

Setup Steps:

Clone or download the repository.
Import the SQL file into your MySQL database to set up the schema.
Configure the database connection in the config.php file.
Deploy the system on your web server.

Accessing the System:

Open the system in a web browser.
Use admin credentials to log in and set up users and roles.

Use Case Scenarios

For Administrators: Easily set up and manage system users and their roles.
For Project Managers: Streamline task monitoring and ensure timely project completion.
For Regular Employees: Efficiently update progress and contribute to task tracking.
