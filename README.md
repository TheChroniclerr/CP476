# Configuration
1. Copy all files into `htdocs`.
If you use command line, then clone the repository (delete .git if you want, so localhost cannot access it, but then syncing updates becomes annoying)
2. Check Apache configuration by going to: http://localhost/html/index.html
3. Check PHP configuration by going to: http://localhost/html/phpinfo.php
4. Go to command line and enter:
```shell
> mysql -u root -P 3306 -p
> (enter your password):
```
You can execute contents of `create_table.txt` here, but it should also work on `database.php`
# Testing
1. Login
	- Go to: http://localhost/html/login.php
	- Default admin account
		Username: admin
		Password: admin
	- If login is successful, you will be automatically redirected to the dashboard
2. Connect to MySQL
	- Go to: http://localhost/html/database.php
		- Or just click "Database" on dashboard
	- Use the password you created following installation guide on Myls
	- Everything else should be same the suggestion
3. Create database
	- Go to: http://localhost/create_table.txt
	- Copy its contents, paste into query in `database.php`, then press submit
	- This creates `cp476` database and all its tables
4. Test query
Show all records from `name` table:
```Mysql
SELECT * FROM name
```
Show all records from `course` table:
```Mysql
SELECT * FROM course
```
# Features
- Stylized.
- Save user sessions.
- Redirection after successful login; do not require re-logins.
- Dashboard.
- MySql connection.
- Display MySql query in tables, along with "EXPLAIN".
- MySql connection page.

# Todo
- Change color theme.
- Write reports.
- Multiple accounts, account information saved in MySql.
- Security implementations (prepare, https).

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
## 2025-03-09
- Fix database key.
- Add database data.
- Implement unsafe multi-query request.
- Update README.txt.
- Add logo on topnav.
# Sources
Lock icon: https://www.flaticon.com/free-icon/lock_891399?term=lock&page=1&position=1&origin=search&related_id=891399
Color Palettes:
- Clay: https://coolors.co/f8f9fa-e9ecef-dee2e6-ced4da-adb5bd-6c757d-495057-343a40-212529
- Gray-scale: https://coolors.co/595959-7f7f7f-a5a5a5-cccccc-f2f2f2
