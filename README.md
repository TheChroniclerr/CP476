# Configuration
1. Copy all files into htdocs.
If use command line, then clone the repository (delete .git if you want, so localhost cannot access it, but then syncing updates becomes annoying).
2. Check Apache configuration by going to: http://localhost/index.html
If you followed the steps in myls correctly, it should display a web page.
3. Check PHP configuration by going to: http://localhost/html/phpinfo.php
If you followed the steps in myls correctly, it should display a web page.
4. Go to command line and enter:
\>mysql -u root -p
\>(enter your password)
\>CREATE DATABASE IF NOT EXISTS `cp476`
CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
(this creates a local database on your device)

# Testing
1. Goto: http://localhost/html/login.php
2. Default admin account
Username: admin
Password: admin
if login is successful, you will be redirected to the dashboard automatically
3. Click the first link to goto: http://localhost/html/connection.php
4. Login using the password you created following installation guide on myls
Everything else should be just as the suggestion.
5. Goto http://localhost/html/database.php
5. Copy content from http://localhost/create_table.md and past it into query, press submit.
This initializes all tables onto database 'cp476'.
6. Run: SELECT \* FROM name_table
this should return no record found.
7. SELECT \* FROM course_table
this should return some test records.

# Features
- Stylized.
- Save user sessions.
- Redirection after successful login; do not require re-logins.
- Dashboard.
- MySql connection.
- Display MySql query in tables, along with "EXPLAIN".
- MySql connection page.

# Todo
- change color theme.
- Fix ReadMe
- Fix database

- Write reports.
- Create seperate .css files.
- Multiple accounts, account information saved in MySql.
- Security implementations.
- https??

# Updates
## 2025-02-14
- Reformat connection syntax.
- Make dbname optional for connection.
- Allow query operations different for each query type.
- Make connection page use relative reference (modular design).
- Combine connection with database.
- Deprecate connection.php.
## 2025-02-15
- Modularize connection field.
- Modularize query field.
- Modularize query result field.
- Add connection disconnect button
- Show settings in connection if already connected.
- Add connection header.
- Fix connection buttons spacing.
## 2025-02-16
- Add top navigation menu.
- Add main contents' side margin.
- Re-stylize all of the above from floating to flex-box layout.
- Implement topnav redirection.
- Implement topnav login/logout.
- Implement dashboard guest mode.
- Modularize topnav.
- Implement working topnav for all web pages.
## 2025-03-08
- Implement default webpage header metadatas.
- Design website logo.
- Implement website logo as favicon.
- Add Roboto Regular custom font.
- Modularize font-family.css.
- Modularize login page.
- Remove deprecated webpages.

- Add php documentations with module dependencies.
- Refactor module variables to include folder name.
- Refactor webpage directory variables for module paths.
- Include session start on all webpages.
- Stylize code.

# Sources
Lock icon: https://www.flaticon.com/free-icon/lock_891399?term=lock&page=1&position=1&origin=search&related_id=891399
Color Palettes:
- Clay: https://coolors.co/f8f9fa-e9ecef-dee2e6-ced4da-adb5bd-6c757d-495057-343a40-212529
- Gray-scale: https://coolors.co/595959-7f7f7f-a5a5a5-cccccc-f2f2f2
