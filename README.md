# My/Blog CMS

**My/Blog CMS** is a content management system (CMS) designed for creating, managing, and engaging with blog content. It provides a platform where users can register either as admins or members. Admins have full control over content creation, enabling them to write and publish blog posts on various programming topics. Members can browse through the posts, read them, and contribute to discussions via the comments section.

This project is ideal for developers, tech enthusiasts, or bloggers who wish to share their knowledge in a structured and interactive format. Built with PHP, MySQLi for the backend, and Bootstrap4 for the frontend, *My/Blog CMS* ensures a smooth and responsive user experience.

### Key Features:
- **Admin Dashboard:** Create, edit, and manage blog posts.
- **User Registration & Authentication:** Role-based access control (Admin vs. Member).
- **Comment System:** Members can leave comments and participate in discussions.
- **Responsive Design:** Mobile-friendly layout thanks to Bootstrap4.

## Installation

To run **My/Blog CMS** locally, follow these steps:

### Prerequisites
Make sure you have the following installed:
- **XAMPP** (or any local server like MAMP, WAMP, etc.)
- **PHP** (version 7.4 or higher)
- **MySQL**

### Steps:
1. **Clone the repository**:
   ```bash
   git clone https://github.com/murat-yasar/my-blog-cms.git
   ```
2. **Move the project to the server root:**

   - If you're using XAMPP, move the cloned folder to C:/xampp/htdocs/.

3. **Start XAMPP (or equivalent):**

   - Open XAMPP Control Panel and start Apache and MySQL.

4. **Set up the database:**

   - Open (phpMyAdmin)[http://localhost:8888/my-blog-cms].
   - Create a new database (e.g., myblog_cms).
   - Import the myblog_cms.sql file from the project to set up the database structure.

5. **Configure the database connection:**

   - Open the project folder and edit the database configuration file (e.g., config.php).
   - Update the following variables:
   ```php
      $dbHost = 'localhost';
      $dbUser = 'root';   // or your MySQL username
      $dbPass = '';       // or your MySQL password
      $dbName = 'myblog_cms';
   ```

6. **Run the application:**

    Visit http://localhost/my-blog-cms to start using the system.

## Contributing

Contributions are welcome! If you'd like to contribute to My/Blog CMS, here are some guidelines to follow:

   1. Fork the repository:
      -  Click the "Fork" button at the top of the repository to create your own copy.

   2. Create a branch:
      -  Make sure to create a new branch before making changes.

      ```bash
         git checkout -b feature/your-feature-name
      ```

   3. Make your changes:

      - Add new features, fix bugs, or improve documentation.

   4. Submit a pull request:

      - Once your changes are complete, submit a pull request to the main branch with a clear description of what you’ve done.

### Guidelines:

   - Follow the coding standards used in the project.
   - Test any new features before submitting a pull request.
   - Be respectful in discussions and during the code review process.

## License

This project is licensed under the MIT License - see the LICENSE file for details.
