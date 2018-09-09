# Simple CRUD using PHP,MYSQL,REACT,BABLE,JQUERY,BOOTSTRAP

## Getting Started
CRUD operations with PHP, MySQL, React, Babel, jQuery and Bootstrap.

### What is React ? (in One Word)
React is only the V in MVC.

### What will do what ?
PHP – will handle server side script.<br/>
MySQL – will store our data.<br/>
React – will make our UI fast and interactive.<br/>
Babel – will compile our JavaScript so we don’t have to wait for browser support.<br/>
jQuery – will do AJAX requests. React official docs shows jQuery examples.<br/>
Bootstrap – will make our UI look better.<br/>

### Installation

Step 1 : Create Database
```
api_db (or Whatever_Name)
```

Step 2 : Import SQL file into Database
```
api_db.sql
```

Step 3 : Update Project Configuration Files 
```
- api/config/core.php
Update following variables as per your server config
$home_url = "http://localhost/Simple-CRUD/";

- api/config/database.php
Update following variables as per your database config
$host = "localhost";
private $db_name = "api_db";
private $username = "root";
private $password = "mysql"; // If you're using xampp keep it blank
```

Step 4 : Go Live
```
http://localhost/Simple-CRUD
```

That's all Folks !!
