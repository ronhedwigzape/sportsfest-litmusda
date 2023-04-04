# User Class

The User class is a PHP class that is used for creating user objects and performing various actions on those objects such as authentication, retrieval of user information and updating user information. It extends the `App` class, which contains the database connection and other common functionalities.

## Requirements

- PHP version 5.6 or higher
- MySQL database

## Installation

1. Copy the `User.php` file to your project directory.
2. Require the `User.php` file in your PHP script where you want to use the User class.

## Usage
### Creating a User Object

To create a user object, instantiate the User class with the username, password and user type as parameters. For example:

```php
$user = new User('johndoe', 'password123', 'customer');
```
### Authentication

To authenticate a user, call the `signIn` method on the User object. This method checks if the provided credentials are valid and sets the user information in the `$_SESSION` variable.

```php
$user->signIn();
```
### Retrieving User Information

To retrieve user information, call the `toArray` method on the User object. This method returns an array of the user information.

```php
$user_info = $user->toArray();
```
### Updating User Information

To update user information, call the respective setter methods on the User object and then call the `update` method.

```php
$user->setName('John Doe');
$user->setAvatar('avatar.jpg');
$user->setNumber(1);
$user->update();
```
### Getting Current User

To get the current user information, call the `getUser` static method. This method retrieves the user information from the `$_SESSION` variable and returns an array.

```php
$current_user = User::getUser();
```
### Other Methods

- `authenticated()` - Checks if the user is authenticated.
- `getId()` - Returns the user ID.
- `getName()` - Returns the user name.
- `getAvatar()` - Returns the user avatar.
- `getNumber()` - Returns the user number.
- `getUsername()` - Returns the user username.
- `getPassword()` - Returns the user password.

### License

This code is released under the MIT License.

```php
<?php

// require the User class file
require_once 'User.php';

// create a new instance of the User class
$user = new User('my_username', 'my_password', 'customer');

// authenticate the user
$user->signIn();

// get the user's name
$name = $user->getName();

// set the user's avatar
$user->setAvatar('path/to/avatar.jpg');

// update the user's information in the database
// ...

// get the user's information as an array
$user_info = $user->toArray();

// output the user's information as JSON
echo json_encode($user_info);
```