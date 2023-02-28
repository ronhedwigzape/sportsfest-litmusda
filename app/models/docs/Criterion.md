This is a PHP script that defines a class called `Criterion` that extends another class called `App`. The `Criterion` class represents a criterion that can be used to evaluate events. The class contains methods for finding, inserting, updating, and retrieving criteria.

### The class has the following properties:

- `$table`: A protected property that stores the name of the table in the database that stores the criteria.  
- `$id`: A protected property that stores the ID of the criterion.  
- `$event_id`: A protected property that stores the ID of the event to which the criterion belongs.  
- `$title`: A protected property that stores the title of the criterion.
- `$percentage`: A protected property that stores the percentage weight of the criterion.

### The class has the following methods:

- `__construct($id = 0)`: A constructor method that takes an optional ID argument and retrieves the criterion's data from the database if an ID is provided.  
- `executeFind($stmt)`: A private static method that executes a prepared statement and returns a Criterion object if the statement returns a result, or false if it does not.  
- `findById($id)`: A public static method that finds a criterion in the database by ID and returns a Criterion object or false if it does not exist.
- `toArray()`: A public method that returns an array representation of the criterion's data.  
- `all($event_id = 0)`: A public static method that retrieves all criteria from the database and returns an array of Criterion objects.
- `rows($event_id = 0)`: A public static method that retrieves all criteria from the database and returns an array of arrays.  
- `exists($id)`: A public static method that returns true if a criterion with the given ID exists in the database, or false if it does not.  
- `insert()`: A public method that inserts a new criterion into the database.  
- `update()`: A public method that updates an existing criterion in the database.