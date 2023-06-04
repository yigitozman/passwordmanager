# Online Password Manager

Online encrypted password manager with PHP, MySQL and MariaDB.


## Project Structure

1. The application starts in **loading_screen.php**.
2. The connection is set up.
3. Database is created if not as well as the table.
4. Redirects to **login_screen.php**.
5. Two options: Login or create user. While creating a new user, validates if there is an existing one with the same username. If not, the user is created. While logging in to an existing account, it checks the given user info (*validateUser* on login_screen.php:**27**).
6. Functions **encrypt** and **decrypt** handles the encryption. Encrypts the data after user creation, decrypts it after a login input comes. An unencrypt data is not located on the database.
7. After logging in, respective user data represented on **main.php** (this is why it is called **main**). It is important to note that this data is also encrypted before sending it to the database.
8. Delete button simply deletes the data (**delete.php**). The logic behind a seperate PHP script is, **delete.php** pulls the respective userdata id and this helps to delete the specific data from database. After the job is done, redirects back to **main.php**.
9. At Windows use mysql -u root -p to log in to MySql in command prompt (Password is empty.)

## Authors

Yiğit Özman - Ege Çam (*Group 8*)

[Click here](https://www.canva.com/design/DAFkUNJWtUw/dslSB90JFlmaSHYCLyx4nQ/edit?utm_content=DAFkUNJWtUw&utm_campaign=designshare&utm_medium=link2&utm_source=sharebutton) for the online presentation.