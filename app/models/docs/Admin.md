# Admin Class

The `admin` is a child class  of the `User` class. It inherits all properties and methods from the `User` class and adds some additional functionality specific to admin users.

### Constructors 

### `__construct($username, $password)`

This constructor takes two optional parameters: `$username` and `$password`. If no values are provided, the default values are used. The constructor sets the `role` property of the `User` class to `'admin'`.

### Public Methods

### `findById($id)`

This method takes an integer `$id` and returns an `Admin` object if an admin with that `$id` exists in the database. Otherwise, it returns `false`.

### `toArray($append)`

This method takes an optional parameter `$append` and returns an array representation of the `Admin` object. If `$append` is provided, it is merged with the properties of the `Admin` object before returning the array.

### `all()`

This method returns an array of all `Admin` objects in the database.

### `rows()`

This method returns an array of arrays, where each sub-array represents an `Admin` object in the database.

### Private Methods

### `executeFind($stmt)`

This method takes a prepared statement `$stmt` and executes it. It then returns a new `Admin` object if a row is returned from the database, and `false` otherwise.

### Dependencies

The `Admin` class requires the `User` class to be included. It also assumes that there is a database table called `admins` with columns `id`, `username`, `password`, and `role`. The database connection is assumed to be stored in the `User` class.

```php
// First, create a new admin user
$newAdmin = new Admin("newadmin", "password123");

// Insert the new admin user into the database
$newAdmin->save();

// Find an admin user by ID
$admin = Admin::findById(1);

// Get all admin users as an array of objects
$admins = Admin::all();

// Get all admin users as an array of arrays
$adminRows = Admin::rows();

// Convert an admin object to an array
$adminArray = $admin->toArray();
```