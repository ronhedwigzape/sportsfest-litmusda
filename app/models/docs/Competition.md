This is a PHP class called `Competition`. It extends another class called `App`.

The class has several properties including `$id`, `$slug`, and `$title`. It has several methods including a constructor that gets information about a competition from a database, `findById` and `findBySlug` methods that find competitions by their respective ID or slug, `toArray` method that converts a competition object to an array, `all` method that gets all competitions as an array of objects, `rows` method that gets all competitions as an array of arrays, `exists` method that checks if a competition ID exists, `slugExists` method that checks if a competition slug exists, and `insert` and `update`  methods to insert and update competition records to a database.

The `executeFind` method is a private method that is used by `findById` and `findBySlug` methods to execute SQL statements and return a `Competition` object if a row is found in the database or `false` otherwise.

The `Competition` class also uses prepared statements to prevent SQL injection attacks.