My Budget
===============

**My first project** written in June-July 2015.

Things that work:
* registration
* registration form's validation
* login
* password hashing
* income/expenses: user can view this week's and this month's income/expenses
* income/expenses: user can log his income and expenses based on categories (Ajax is used to avoid page reloading)
* responsive design (screenshots below)

Technologies used: PHP, Symfony2, Bootstrap, jQuery, Ajax, MySQL.

Screenshots
------------------

### Expenses page:

![Expenses page](/ReadmeImages/expenses.PNG)

### Income page (mobile view):

![Income page mobile](/ReadmeImages/incomeMobile.PNG)

### Registration page:

![Registration page](/ReadmeImages/register.PNG)

### Registration page (mobile view):

![Registration page mobile](/ReadmeImages/registerMobile.PNG)

### Login page:

![Login page](/ReadmeImages/login.PNG)

### Login page: (mobile view):

![Login page mobile](/ReadmeImages/loginMobile.PNG)


### **Instructions how to run the project (for Ubuntu)**

1. clone the repository

2. update Ubuntu repositories:

    ```sudo apt-get update```

3. go the the project directory and install composer (for non Ubuntu systems check the
[documentation](https://getcomposer.org)):

    ```sudo apt install composer```

    ```sudo apt-get install php7.0-xml```

    ```composer update```

    After that you will be asked to provide missing parameters, such as: database_name, database port (3306), etc.

4. install mysql-server:

    ```sudo apt-get install mysql-server```

5. create the database with matching database_name from step 3

    ```CREATE DATABASE <database_name>```

6. Install php-mysql driver:

    ```sudo apt-get install php-mysql```

7. run migrations:

    ```php app/console doctrine:schema:update --force --complete```

8. run the server:

    ```php app/console server:run```

Click on the url in the console. Registration window will open. 
After registration user is redirected to /login page. He can login to his account, log his expenses/income and logout. 
If user is already registered, he can go directly to /login page.
