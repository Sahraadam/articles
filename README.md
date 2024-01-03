**Project Name: Articles Management System**

**Description:**

Welcome to the Articles Management System project, a robust web application designed to manage users, articles, and authors efficiently. This project is built using PHP and MySQLi to provide a secure and organized environment for handling user data.

**Key Features:**

1. **Database Setup:**
   - Create a MySQL database with two main entities: Users and Articles, to store essential information.
   - Define fields for Users: userId, Full_Name, email, phone_Number, User_Name, Password, UserType, AccessTime, profile_Image, Address.
   - Define fields for Articles: authorId (FK), article_title, article_full_text, article_created_date, article_last_update, article_display (yes or no), article_order.

2. **PHP OOP Database Operations:**
   - Implement PHP OOP code for essential database operations.
   - Constants (Host_Name, Database_User, Password, Database_Name) stored in constant.php.
   - Establish a secure connection to the MySQLi database server.

3. **User Authentication:**
   - Create a login page for Super_Users to access the system.
   - Super_Users can update their profiles, manage other users, view articles, and logout.

4. **Super_User Functionality:**
   - Update profile: Super_Users can modify personal details, excluding the username.
   - Manage Other Users: Super_Users can add, list, update, delete users, and export user lists to PDF, text file, and Excel.
   - View Articles: Display the last 6 posted articles in descending order by article_created_date.
   - Logout: Super_Users can sign out of the system.

5. **Administrator and Author Roles:**
   - Administrators and Authors have similar functionalities with slight differences in managing authors and articles.

6. **Author Functionality:**
   - Update profile: Authors can modify personal details.
   - Manage Articles: Authors can add, list, update, and delete articles.
   - View Articles: Display the last 6 posted articles with export links (PDF and text file).
   - Logout: Authors can sign out of the system.

7. **Additional Tips:**
   - Plan your web page layout on paper.
   - Implement session protection, except for index.php.
   - Email notifications for administrators on new article posts.
   - Use `require_once connection.php` on each page for database connectivity.
   - Utilize MySQLi Object-oriented or MySQLi Procedural for database interactions.
   - Host your project on [000webhost](https://www.000webhost.com/) and share the link before Friday, 5th January 2024, 4:30 PM.

**Hosted Website:**
[Articles Management System](https://sanative-ringing.000webhostapp.com/index.html#section-1)

Explore the features of the User Management System and manage your users, articles, and authors seamlessly.
