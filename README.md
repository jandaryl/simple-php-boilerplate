# Simple PHP Boilerplate
- This project only exists for helping my colleagues in school.

 ## Table of Contents

- [Concepts](#concepts-)
    - [Files Controller](#files-controller)
    - [Seperation of Ideas](#seperation-of-ideas)
    - [Level of Useability](#level-of-useability)
    - [Organize the Files](#organize-the-files)
- [Advantages](#advantages-)
- [Knowledge Requirements](#knowledge-requirements-)
- [Features](#features-)
- [Getting Started](#getting-started)
- [Overview](#overview)
    - [Nice Configurations](#nice-configurations)
    - [Easy Validation](#easy-validation)
    - [CSRF Protection](#csrf-protection)
    - [Secure Password](#secure-password)
    - [Sql Injection Protection](#sql-injection-protection)
- [Core Classes](#core-classes-)
    - [Cookie Class](#cookie-class)
    - [Database Class](#database-class)
    - [Hash Class](#hash-class)
    - [Helper Functions](#helper-functions)
    - [Input Class](#input-class)
    - [Password Class](#password-class)
    - [Redirect Class](#redirect-class)
    - [Session Class](#session-class)
- [Helpful Classes](#helpful-classes-)
    - [Token Class](#token-class)
    - [User Class](#user-class)
    - [Validation Class](#validation-class)

### Concepts :
When you use this app the first things you'll notice are the files and folder in the directory. The app folder composed of frontend and backend folders, which separates the front design and backend logic. The files that you saw in the outside of the app folder, I think as the controllers, think this as you play a jigsaw puzzle, you need to connect the different pieces to solve it or form it. So.. as you see the content of the files, there is no logic or designs include on it, except the require once function that use to insert or connect the files. Those require name defined in the 'start.php', to make it easier to memorize, act as an alias or be constant for the file locations.

To understand the structure and idea of this app, think in this way;

##### Files Controller
The files that outside in the app folders are puzzles that you need to solve. Then the files inside in the app folder are the pieces of a puzzle that you need to require or connect.

##### Separation of Ideas
The app folder contains two folders that are frontend and backend folder. Think of it as the separation of logic and design in your application.

##### Level of Usability
The backend folder contains auth, classes, core folders. The lower the level, the low chance that you will use in your logic. Auth is level 2, Classes is level 1, and Core is level 0. So in Auth folder, where you will put your logic that connects from your frontend pages. Then the classes folders are your objects or tools that logic behind in Auth files. Then the Core folder is the abstract ideas behind your classes folder. And that's it.

##### Organize the Files
The Frontend folder contains assets, includes, and pages folders which were chopped to reuse your design and codes. Like assets folder where the css, js, images lived, includes folder where the headers, navbar, messages, footer are separated and the pages folder where you all your application pages lived.



### Advantages :

- Organize File Structure
- High Security
- Code Reuseable

### Knowledge Requirements :

- [PHP Programming Basics](https://www.youtube.com/watch?v=XKWqdp17BFo&list=PLfdtiltiRHWHjTPiFDRdTOPtSyYfz3iLW)
- [Good Understanding in OOP](https://www.youtube.com/watch?v=ipp4WPDwwvk&list=PLfdtiltiRHWF0RicJb20da8nECQ1jFvla) (optional)
- Open Minded

### Features :

- Nice Configurations
- Easy Validation
- CSRF Protection
- Secure Password
- Sql Injection Protection
- A lot of helpful classes.

### Getting Started

#### [Download ZIP](https://github.com/jandaryl/simple-php-boilerplate/archive/master.zip) or Git Clone
```php
git clone https://github.com/jandaryl/simple-php-boilerplate.git
```

### Setup environment

Follow the steps below:

1. [Download and install Xampp](https://www.apachefriends.org/download.html), which is used to manage the system.
2. Move the files to the htdocs folder of Xampp.
3. Import the database and set the configuration. 

### Overview

#### Nice Configurations

``` php
<?php
// app/backend/auth/config.php

$GLOBALS['config'] = array(
    'app' => array(
        'name'          => 'AppName',
    ),
    'mysql' => array(
        'host'          => '127.0.0.1',
        'username'      => 'root',
        'password'      => '',
        'db_name'        => 'php_boilerplate'
    ),
    ...

<?php
// app/backend/core/Database.php
require_once 'app/backend/auth/config.php';
...
$pdo = new PDO('mysql:host='.Config::get('mysql/host').';'. // 127.0.0.1
        'dbname='.Config::get('mysql/db_name'),             // php_boilerplate
                  Config::get('mysql/username'),            // root
                  Config::get('mysql/password')             // ''
    );
```

#### Easy Validation

```php
<?php
// app/backend/auth/update-account.php
require_once 'app/backend/classes/Validation.php';

$validate = new Validation();

$validation = $validate->check($_POST, array(
        'username'  => array(
            'required'  => true,
            'min'       => 2,
            'unique'    => 'users'
        ),
        'current_password'  => array(
            'required'  => true,
            'min'       => 6,
            'verify'    => 'password'
        ),
        'new_password'  => array(
            'optional'  => true,
            'min'       => 6,
            'bind'      => 'confirm_new_password'
        )
        'confirm_new_password' => array(
            'optional'  => true,
            'min'       => 6,
            'match'     => 'new_password',
            'bind'      => 'new_password',
            ),
        ));

if ($validate->passed() {
    // Awesome Logic...
} else {
    echo $validate->$error(); // First error message.

    foreach ($validate->errors() as $error) // All error messages.
    {
        echo $error;
    }
}
...
```

### CSRF Protection

```php
<?php
// 'app/frontend/pages/update-account.php';
require_once 'app/backend/classes/Token.php';

...
<input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">
<input type="submit" value="Register me">
...

<?php
// 'app/backend/auth/update-account.php';
require_once 'app/backend/core/Input.php';
require_once 'app/backend/classes/Token.php';
...
if (Token::check(Input::get('csrf_token')) {
    // Do validation stuff...
}
...
```

### Secure Password

```php
<?php
// app/backend/auth/config.php
...
'password' => array(
        'algo_name' => PASSWORD_DEFAULT,
        'cost'      => 10,
        'salt'      => 50,
),
...

<?php
// app/backend/auth/register.php
require_once app/backend/core/Password.php
...
$user->create(array(
     ...
    'password'  => Password::hash(Input::get('password')),
     ...
    ));
...

<?php
// app/backend/auth/register.php
require_once app/backend/classes/Validation.php
...
if (Password::check($value, $this->_user->data()->password)) {
    // Do awesome stuff...
}
...
```

### Sql Injection Protection
```php
<?php
// app/backend/core/Database.php
...
$this->_pdo = new PDO('mysql:host='.Config::get('mysql/host')...);
...
$this->_query->bindvalue($x, $param);
...
$this->_results     = $this->_query->fetchAll(PDO::FETCH_OBJ);
...

```

### Core Classes :

#### Cookie Class
```php
<?php
require_once 'app/backend/core/Cookie.php';
// check if cookie name is exists
if (Cookie::exists(Config::get('remember/cookie_name'))) {
    // ...
}

// get the cookie value
$cookie_value = Cookie::get(Config::get('remember/cookie_name'));

// delete the cookie value
$cookie_value = Cookie::delete(Config::get('remember/cookie_name'));

```

#### Database Class
```php
<?php
require_once 'app/backend/core/Database.php';

// Make Connection
$database = Database::getInstance();

// Get the data from database.
// $database->get($table, $where = array())
$database->get('users', array('id', '=', '13');

// Insert the data to database.
// $database->insert($table, $fields = array())
$database->insert('users', array(
                  'username'  => 'johnny123',
                  'password'  => Password::hash('secret'),
                  'name'      => 'JohnDoe',
                  'joined'    => date('Y-m-d H:i:s')
               ));

// Update the data from database.
// $database->update($table, $id, $fields = array())
$database->update('users', '13', array(
                  'username'  => 'newusernname',
                  'password'  => Password::hash('newsecret'),
                  'name'      => 'newname',
               ));

// Delete the data from database.
// $database->delete($table, $where = array())
$database->delete('users', array('id', '=', '13');

// Get the first data from database.
$database->first();

// Count the data from database.
$database->count();

// Return a results of object data from database.
$database->results();

// Get error from query.
$database->error();

```
#### Hash Class
```php
<?php
require_once 'app/backend/core/Hash.php';

// Make a hash base on the algorithm in config.
$hash = Hash::make('string');

// Generate a unique hash.
$hash = Hash::unique();

```

#### Helper Functions
```php
<?php
require_once 'app/backend/core/Helpers.php';

escape('string');       // convert the html entities to quotes.
autoload($classname);   // use to auto register all classes.
cleaner('string');      // remove the /_/ then make upper the string.

```
#### Input Class
```php
<?php
require_once 'app/backend/core/Input.php';

// Check the request if empty such as post or get.
if (Input::exists()) {
    // Do some validation..
}

// Get the value from that request.
Input::get('csrf_token');

```
#### Password Class
```php
<?php
require_once 'app/backend/core/Password.php';

// Generate a hash based on the configs.
$hash_password = Password::hash('secret');

// Check the hash if it needed to rehash.
// This will occur if you changed the password config.
if (Password::rehash('hash')) {
    // Hash the password..
}

// Verify the password from database stored hash.
if (Password::check('secret', 'hash')) {
    // Do awesome stuff...
}

// Get the hash information. E.g. algo_name, cost, or salt.
$password_info = Password::getInfo('hash');

```

#### Redirect Class
```php
<?php
require_once 'app/backend/core/Redirect.php';

// Redirect the user from location that specify.
Redirect::to('index.php');

```
#### Session Class
```php
<?php
require_once 'app/backend/auth/config.php';
require_once 'app/backend/core/Session.php';

// Check the session name if exists in the server.
if (Session::exists(Config::get('session/session_name'))) {
    // Do awesome stuff...
}

// Get the session name value.
$session_value = Session::get(Config::get('session/session_name'));

// Delete the session name value.
Session::delete(Config::get('session/session_name'));

// Set a flash message to display to the user.
// Use this if want to message the user by their operation.
// flash($message-name, $message)
Session::flash('register-success', 'Thanks for registering! You can login now.');

```

### Helpful Classes :
#### Token Class
```php
<?php
require_once 'app/backend/classes/Token.php';

// Generate token for csrf protection.
$csrf_token = Token::generate();

// Check token if equal to the user token.
if (Token::check($token)) {
    // Do more validation...
}

```
#### User Class
```php
<?php
require_once 'app/backend/classes/User.php'

// Make an instance for user.
$user = new User();

// Note : Don't let this fool you..
//        The logic was the same in database query.
//        It just encapsulated by User Class.

// Create a user data.
$user->create(array(
            'username'  => Input::get('username'),
            'password'  => Password::hash(Input::get('password')),
            'name'      => Input::get('name'),
            'joined'    => date('Y-m-d H:i:s'),
        ));

// Update the user data.
$user->update(array(
            'username'  => Input::get('username'),
            'password'  => Password::hash(Input::get('password')),
            'name'      => Input::get('name'),
            'joined'    => date('Y-m-d H:i:s'),
        ), '13');

// Find the user if exists.
$user->find('13');          // return true or false
$user->find('johnny123');   // return true or false

// Login the user.
// The 3rd argument is to check if the user want to remember.
$user->login('johnny123', 'secret', true);

// Check the user if exists.
$user->exists();

// Logout the user.
// Delete the session and cookie that attached.
$user->logout();


// Get the user data in object way.
$user->data();
$user->data()->username;    // 'johnny123'
$user->data()->name;        // 'JohnDoe'

// Check if the user logged in.
$user->isLoggedIn();        // Return true or false.

// Delete the data from database.
$user->deleteMe();

```
#### Validation Class
```php
<?php
require_once 'app/backend/classes/Validation.php'

// Make an new instance of Validation.
$validate   = new Validation();

//  Available Rules :                               Notes :
//          optional => true,               'can be null or no value'
//          required => true,               'cannot be null or no value'
//          bind     => 'input_name',       'make connect to other input'
//          min      => 'any_number',       'minimum length of that input'
//          max      => 'any_number',       'maximum length of that input'
//          match    => 'input_name',       'check if match input from another'
//          email    => true,               'check the input if valid email'
//          alnum    => true,               'check if the input alpha numeric'
//          unique   => 'table_name',       'check if the input unique from table'
//          verify   => 'password',         'only in password, check the current'

$validation = $validate->check($_POST, array(
                'username'  => array(
                    'required'  => true,
                    'unique' => 'users',
                    'min' => 2,
                    'max' => 20,
                    'matches' => 'password',
                    alnum    => true
                ),
            ));

// Check if there is an errors.
if ($validate->passed() {
    // Query to the database...
} else {
    // For first error message.
    // echo $validate->$error();

    // For all error messages.
    foreach ($validate->errors() as $error)
    {
        echo $error;
    }
}

```

Thanks for reading! I hope this is useful...

### License

Simple PHP Boilerplate is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


