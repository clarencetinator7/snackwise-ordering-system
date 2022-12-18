
# Snackwise Ordering System

The objective of this project is to design and implement a web-based ordering system
that allows Snackwise costumers to view the menu and place orders online.

**Scope**: The system will have a user-friendly and responsive interface that allows customers to browse and 
select items from a menu, view their shopping cart. The system will also have a backend 
component that allows the business to manage orders and update the menu.


## Features

- **Product catalog**: Customers can browse and filter items into category.
- **Shopping cart**: Customers can add items to their cart and view a summary of theirorder before checkout.
- **Notification**: Upon checking out, costumers will get an update through the notification feed for the status of their order.
- **Order management**: The business can view andmanage orders, and update order statuses.
- **Customer accounts**: Customers can create and manage their own accounts, including viewing order history.

## Build with

- ![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
- ![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white)
- ![Bootstrap](https://img.shields.io/badge/bootstrap-%23563D7C.svg?style=for-the-badge&logo=bootstrap&logoColor=white)
- ![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E)
- ![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)
## Getting Started

Since this project is built with PHP, we suggest to run the project with **XAMPP**.

1. Clone the project using `gitbash`.

```bash
  git clone https://github.com/clarencetinator7/SnackwiseOrderingSystem
```

2. Start *Apache* and *My SQL* in XAMPP

3. Import the SQL File (`public_html/snackwise.sql`) through PHPMyAdmin.

4. Modify the database connection settings in: `public_html/php/classes/DbConnection.php`

```php
  public $dbHost = "localhost"; // Name of Host
  public $dbUser = "root"; // MySQL Username
  public $dbPassword = ""; // MySQL Password
  public $dbName = "snackwise"; // Databse Name
```

### Optional Process

If you already tried the project and you found that checking out gets stuck on loading. If error like this is thrown: 
```
  Uncaught Error: Call to undefined function ImageCreate()
```
You have to do this extra process.
- This issue is from the **PHP QR Code Library** and it means that your installation of PHP doesn't have the `gd-library` installed / enabled.

1. Locate `php.ini` in `c:\xampp\php\php.ini`.
2. Open the file in notepad or other text editor.
3. Search for `;extension=gd`
4. Remove the ';' and it should look like this:
```
  extension=gd
```
5. Save and restart the server.

*For more information please refer to this:*

- https://stackoverflow.com/questions/7851011/how-do-i-install-gd-on-my-windows-server-version-of-php
- https://stackoverflow.com/questions/3106991/fatal-error-call-to-undefined-function-imagecreate

