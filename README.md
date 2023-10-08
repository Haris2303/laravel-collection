<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Collection

Collection merupakan bagian integral dari kerangka kerja Laravel dan memberikan fungsionalitas tambahan untuk mempermudah pengelolaan dan pengolahan data.

## Table of Contents

### [Create Collection](#create-collection-1)

### [ForEach](#foreach-1)

### [Manipulation Collection](#manipulation-collection-1)

### [Mapping](#mapping-1)

### [Zipping](#zipping-1)

### [Flattening](#flattening-1)

### [String Representation](#string-representation-1)

### [Filtering](#filtering-1)

### [Partitioning](#partitioning-1)

### [Testing](#testing-1)

## Contents

### Create Collection

```php
public function testCreateCollection()
{
    $collection = collect([1, 2, 3, 5]);
    self::assertEqualsCanonicalizing([1, 2, 3, 5], $collection->all());
}
```

### ForEach

```php
public function testForEach()
{
    $collection = collect([1, 2, 3, 4, 5, 6]);
    foreach ($collection as $key => $value) {
        self::assertEquals($key + 1, $value);
    }
}
```

### Manipulation Collection

```php
public function testCrud()
{
    $collection = collect([]);
    $collection->push(1, 2, 3, 4);
    self::assertEqualsCanonicalizing([1, 2, 3, 4], $collection->all());

    $result = $collection->pop();
    self::assertEquals(4, $result);
    self::assertEquals([1, 2, 3], $collection->all());
}
```

### Mapping

#### map(function)

```php
public function testMap()
{
    $collection = collect([1, 2, 3]);
    $result = $collection->map(fn ($item) => $item * 2);
    self::assertEqualsCanonicalizing([2, 4, 6], $result->all());
}
```

#### mapInto(class)

```php
public function testMapInto()
{
    $collection = collect(["Otong"]);
    $result = $collection->mapInto(Person::class);
    self::assertEquals([new Person("Otong")], $result->all());
}
```

### mapSpread(function)

```php
public function testMapSpread()
{
    $collection = collect([
        ['Ucup', 'Surucup'],
        ['Otong', 'Surotong']
    ]);
    $result = $collection->mapSpread(fn ($firstname, $lastname) => new Person("$firstname $lastname"));
    self::assertEquals([
        new Person('Ucup Surucup'),
        new Person('Otong Surotong')
    ], $result->all());
}
```

#### mapToGroups(function)

```php
public function testMapToGroups()
{
    $collection = collect([
        [
            'name' => 'Otong',
            'departement' => 'IT'
        ],
        [
            'name' => 'Udin',
            'departement' => 'HR'
        ],
        [
            'name' => 'Ucup',
            'departement' => 'IT'
        ]
    ]);

    $result = $collection->mapToGroups(fn ($person) => [
        $person['departement'] => $person['name']
    ]);

    self::assertEquals([
        'IT' => collect(['Otong', 'Ucup']),
        'HR' => collect(['Udin'])
    ], $result->all());
}
```

### Zipping

#### zip(collection)

```php
public function testZip()
{
    $collection1 = collect([1, 2, 3]);
    $collection2 = collect([4, 5, 6]);
    $collection3 = $collection1->zip($collection2);

    self::assertEquals([
        collect([1, 4]),
        collect([2, 5]),
        collect([3, 6])
    ], $collection3->all());
}
```

#### concat(collection)

```php
public function testConcat()
{
    $collection1 = collect([1, 2, 3]);
    $collection2 = collect([4, 5, 6]);
    $collection3 = $collection1->concat($collection2);

    self::assertEquals([1, 2, 3, 4, 5, 6], $collection3->all());
}
```

#### combine(collection)

```php
public function testCombine()
{
    $collection1 = collect(["name", "country"]);
    $collection2 = collect(["Otong", "Indonesian"]);
    $collection3 = $collection1->combine($collection2);

    self::assertEqualsCanonicalizing([
        'name' => 'Otong',
        'country' => 'Indonesian'
    ], $collection3->all());
}
```

### Flattening

#### collapse()

```php
public function testCollapse()
{
    $collection = collect([
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9]
    ]);
    $result = $collection->collapse();
    self::assertEqualsCanonicalizing([1, 2, 3, 4, 5, 6, 7, 8, 9], $result->all());
}
```

#### flatMap(function)

```php
public function testFlatMap()
{
    $collection = collect([
        [
            'name' => 'Asep',
            'hobbies' => ['Swimming', 'Sing']
        ],
        [
            'name' => 'Otong',
            'hobbies' => ['Driving', 'Running']
        ]
    ]);
    $result = $collection->flatMap(fn ($item) => $item['hobbies']);
    self::assertEquals(['Swimming', 'Sing', 'Driving', 'Running'], $result->all());
}
```

### String Representation

#### join(string, string)

```php
public function testStringRepresentation()
{
    $collection = collect(['Samsul', 'Udin', 'Jamal']);

    self::assertEquals('Samsul-Udin-Jamal', $collection->join('-'));
    self::assertEquals('Samsul-Udin_Jamal', $collection->join('-', '_'));
    self::assertEquals('Samsul, Udin dan Jamal', $collection->join(', ', ' dan '));
}
```

### Filtering

#### filter(function(value, key))

```php
public function testFilter()
{
    $collection = collect([
        'Udin' => 90,
        'Ucup' => 69,
        'Sugi' => 78,
    ]);

    $result = $collection->filter(fn ($value, $key) => $value > 75);

    self::assertEquals([
        'Udin' => 90,
        'Sugi' => 78
    ], $result->all());
}
```

### Partitioning

#### partition(funtion)

```php
public function testPartition()
{
    $collection = collect([
        'Asep' => 87,
        'Udin' => 98,
        'Budi' => 75
    ]);

    [$result1, $result2] = $collection->partition(fn ($value, $key) => $value >= 80);

    self::assertEquals([
        'Asep' => 87,
        'Udin' => 98
    ], $result1->all());

    self::assertEquals([
        'Budi' => 75
    ], $result2->all());
}
```

### Testing

-   Testing adalah operasi untuk mengecek isi data collection
-   Hasil dari testing adalah boolean, dimana true jika sesuai kondisi, dan false jika tidak sesuai kondisi

| Method               | Keterangan                                                                                    |
| -------------------- | --------------------------------------------------------------------------------------------- |
| has(array)           | Mengecek apakah collection memiliki semua key data                                            |
| hasAny(array)        | Mengecek apakah collection memiliki salah satu key data                                       |
| contains(value)      | Mengecek apakah collection memiliki value                                                     |
| contains(key, value) | Mengecek apakah collection memiliki data key dan value                                        |
| contains(function)   | Iterasi tiap data, mengirim ke function dan mengecek apakah salah satu data menghasilkan true |

```php
public function testTesting()
{
    $collection = collect(['Udin', 'Samsul', 'Ucup']);
    self::assertTrue($collection->contains('Udin'));
    self::assertTrue($collection->contains(fn ($value, $key) => $value == "Samsul"));
}
```

### Grouping

-   Grouping adalah operasi untuk meng-grup kan element-element yang ada di collection.

| Method            | Keterangan                                       |
| ----------------- | ------------------------------------------------ |
| groupBy(key)      | Menggabungkan data collection per key            |
| groupBy(function) | Menggabungkan data collection per hasil function |

```php
public function testGrouping()
{
    $collection = collect([
        [
            'name' => 'Samsul',
            'departement' => 'HR'
        ],
        [
            'name' => 'Udin',
            'departement' => 'IT'
        ],
        [
            'name' => 'Otong',
            'departement' => 'IT'
        ]
    ]);

    $result = $collection->groupBy('departement');

    self::assertEquals([
        'IT' => collect([
            [
                'name' => 'Udin',
                'departement' => 'IT'
            ],
            [
                'name' => 'Otong',
                'departement' => 'IT'
            ]
        ]),
        'HR' => collect([
            [
                'name' => 'Samsul',
                'departement' => 'HR'
            ]
        ])
    ], $result->all());

    $result = $collection->groupBy(fn ($value, $key) => strtolower($value['departement']));

    self::assertEquals([
        'it' => collect([
            [
                'name' => 'Udin',
                'departement' => 'IT'
            ],
            [
                'name' => 'Otong',
                'departement' => 'IT'
            ]
        ]),
        'hr' => collect([
            [
                'name' => 'Samsul',
                'departement' => 'HR'
            ]
        ])
    ], $result->all());
}
```
