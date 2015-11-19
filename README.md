array-filter-path
=================

Example
-------

Take for example this array :

```php
$baseArray = array(
  'director' => array(
     'first_name' => 'Robert',
     'last_name' => 'Zemeckis',
  ),
  'actors' => array(
    array(
      'first_name' => 'Michael J.',
      'last_name' => 'Fox',
    ),
    array(
      'first_name' => 'Christopher',
      'last_name' => 'Lloyd',
    ),
  ),
  'label' => 'Back to the Future'
);
```

If we filter it like this :

```php
use agallou\ArrayFilterPath\ArrayFilterPath as ArrayFilterPath;
$filter = new ArrayFilterPath();
$filters = array(
  'actors[].last_name',
  'label',
);
$filteredArray = $filter->($baseArray, $filters);
```

We will get an array like this, with only the actors last name and the label :

```php
array(
  'actors' => array(
    array(
      'last_name' => 'Fox',
    ),
    array(
      'last_name' => 'Lloyd',
    ),
  ),
  'label' => 'Back to the Future'
);
```
