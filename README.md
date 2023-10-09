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

### [Grouping](#grouping-1)

### [Slicing](#slicing-1)

### [Take & Skip](#slicing-1)

### [Chunked](#chunked-1)

### [Retrieve](#retrieve-1)

### [Random](#random-1)

### [Checking Existence](#checking-existence-1)

### [Ordering Operations](#ordering-operations-1)

### [Aggregate](#aggregate-1)

### [Reduce](#reduce-1)

### [Lazy Collection](#lazy-collection-1)

### Method Lainnya Api Docs Laravel

-   [Laravel API](https://laravel.com/api/10.x/Illuminate/Support/Collection.html)
-   [Laravel Docs](https://laravel.com/docs/10.x/collections#available-methods)

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

### Slicing

-   Slicing adalah operasi untuk mengambil sebagian data di Collection

| Method               | Keterangan                                           |
| -------------------- | ---------------------------------------------------- |
| slice(start)         | Mengambil data mulai dari start sampai data terakhir |
| slice(start, length) | Mengambil data mulai dari start sepanjang length     |

```php
public function testSlice()
{
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);

    // slice(start)
    $result = $collection->slice(4);
    self::assertEqualsCanonicalizing([5, 6, 7, 8, 9], $result->all());

    // slice(start, length)
    $result = $collection->slice(6, 2);
    self::assertEqualsCanonicalizing([7, 8], $result->all());
}
```

### Take & Skip

-   Untuk mengambil sebagian element di collection, selain menggunakan slice, kita juga bisa menggunakan operator take dan skip

#### Take

| Method              | Keterangan                                                                                                      |
| ------------------- | --------------------------------------------------------------------------------------------------------------- |
| take(length)        | Mengambil data dari awal sepanjang length, jika length negative artinya proses pengambilan dari posisi belakang |
| takeUntil(function) | Iterasi tiap data, ambil tiap data sampai function mengembalikan nilai true                                     |
| takeWhile(function) | Iterasi tiap data, ambil tiap data sampai function mengembalikan nilai false                                    |

```php
public function testTake()
{
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);

    // take(length)
    $result = $collection->take(4);
    self::assertEqualsCanonicalizing([1, 2, 3, 4], $result->all());

    // takeUntil(function)
    $result = $collection->takeUntil(fn ($value, $key) => $value == 4);
    self::assertEqualsCanonicalizing([1, 2, 3], $result->all());

    // takeWhile(function)
    $result = $collection->takeWhile(fn ($value, $key) => $value < 3);
    self::assertEqualsCanonicalizing([1, 2], $result->all());
}
```

#### Skip

| Method              | Keterangan                                                                          |
| ------------------- | ----------------------------------------------------------------------------------- |
| skip(length)        | Ambil seluruh data kecuali sejumlah length data diawal                              |
| skipUntil(function) | Iterasi tiap data, jangan ambil tiap data sampai function mengembalikan nilai true  |
| takeWhile(function) | Iterasi tiap data, jangan ambil tiap data sampai function mengembalikan nilai false |

```php
public function testSkip()
{
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);

    // skip(length)
    $result = $collection->skip(3);
    self::assertEqualsCanonicalizing([4, 5, 6, 7, 8, 9], $result->all());

    // skipUntil(function)
    $result = $collection->skipUntil(fn ($value, $key) => $value == 3);
    self::assertEqualsCanonicalizing([3, 4, 5, 6, 7, 8, 9], $result->all());

    // skipWhile(function)
    $result = $collection->skipWhile(fn ($value, $key) => $value < 6);
    self::assertEqualsCanonicalizing([6, 7, 8, 9], $result->all());
}
```

### Chunked

-   Chunked adalah operasi untuk memotong Collection menjadi beberapa Collection

| Method        | Keterangan                                                                                       |
| ------------- | ------------------------------------------------------------------------------------------------ |
| chunk(number) | Potong collection menjadi lebih kecil dimana tiap collection memiliki sejumlah total data number |

```php
public function testChunk()
{
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8]);

    $result = $collection->chunk(3);
    self::assertEqualsCanonicalizing([1, 2, 3], $result[0]->all());
    self::assertEqualsCanonicalizing([4, 5, 6], $result[1]->all());
    self::assertEqualsCanonicalizing([7, 8], $result[2]->all());
}
```

### Retrieve

-   Retrieve adalah operasi untuk mengambil data di Collection

#### First Operations

| Method                 | Keterangan                                                                                            |
| ---------------------- | ----------------------------------------------------------------------------------------------------- |
| first()                | Mengambil data pertama di collection, atau null jika tidak ada                                        |
| firstOrFail()          | Mengambil data pertama di collection, atau error ItemNotFoundException jika tidak ada                 |
| first(function)        | Mengambil data pertama di collection yang sesuai dengan kondisi function jika menghasilkan nilai true |
| firstWhere(key, value) | Mengambil data pertama di collection dimana key sama dengan value                                     |

```php
public function testFirst()
{
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

    // first()
    $result = $collection->first();
    self::assertEquals(1, $result);

    // first(function)
    $result = $collection->first(fn ($value, $key) => $value > 5);
    self::assertEqualsCanonicalizing(6, $result);
}
```

#### Last Operations

| Method         | Keterangan                                                                                             |
| -------------- | ------------------------------------------------------------------------------------------------------ |
| last()         | Mengambil data terakhir di collection, atau null jika tidak ada                                        |
| last(function) | Mengambil data terakhir di collection yang sesuai dengan kondisi function jika menghasilkan nilai true |

```php
public function testLast()
{
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

    // last()
    $result = $collection->last();
    self::assertEquals(10, $result);

    // last(function)
    $result = $collection->last(fn ($value, $key) => $value < 5);
    self::assertEqualsCanonicalizing(4, $result);
}
```

### Random

-   Random adalah operasi untuk mengambil data di collection dengan posisi random

| Method        | Keterangan                                                    |
| ------------- | ------------------------------------------------------------- |
| random()      | Mengambil satu data collection dengan posisi random           |
| random(total) | Mengambil sejumlah total data collection dengan posisi random |

```php
public function testRandom()
{
    $collection = collect([1, 2, 3, 4, 5]);

    // random()
    $result = $collection->random();
    self::assertTrue(in_array($result, [1, 2, 3, 4, 5]));

    // random(function)
    $result = $collection->random(5);
    self::assertEquals([1, 2, 3, 4, 5], $result->all());
}
```

### Checking Existence

-   Checking Existence merupakan operasi untuk mengecek apakah terdapat data yang dicari di Collection

| Method             | Keterangan                                                                               |
| ------------------ | ---------------------------------------------------------------------------------------- |
| isEmpty(): bool    | Mengecek apakah collection kosong                                                        |
| isNotEmpty()       | Mengecek apakah collection tidak kosong                                                  |
| contains(value)    | Mengecek apakah collection memiliki value                                                |
| contains(function) | Mengecek apakah collection memiliki value dengan kondisi function yang menghasilkan true |
| containsOneItem()  | Mengecek apakah collection hanya memiliki satu data                                      |

```php
public function testCheckingExistence()
{
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8]);

    // isNotEmpty()
    $this->assertTrue($collection->isNotEmpty());
    // isEmpty()
    $this->assertFalse($collection->isEmpty());
    // contains(value)
    $this->assertTrue($collection->contains(4));
    // contains(function)
    $this->assertTrue($collection->contains(fn ($value, $key) => $value % 3 == 0));
}
```

### Ordering Operations

-   Ordering adalah operasi untuk melakukan pengurutan data di Collection

| Method                   | Keterangan                                                  |
| ------------------------ | ----------------------------------------------------------- |
| sort()                   | Mengurutkan secara ascending                                |
| sortBy(key/function)     | Mengurutkan secara ascending berdasarkan key atau function  |
| sortDesc()               | Mengurutkan secara descending                               |
| sortByDesc(key/function) | Mengurutkan secara descending berdasarkan key atau function |
| sortKeys()               | Mengurutkan secara ascending berdasarkan keys               |
| sortKeysDesc()           | Mengurutkan secara descending berdasarkan keys              |
| reverse()                | Membalikkan urutan collection                               |

### Aggregate

-   Laravel collection juga memiliki beberapa method untuk melakukan aggregate

| Method            | Keterangan                    |
| ----------------- | ----------------------------- |
| min()             | Mengambil data paling kecil   |
| max()             | Mengambil data paling besar   |
| avg() / average() | Mengambil rata-rata data      |
| sum()             | Mengambil seluruh jumlah data |
| count()           | Mengambil total seluruh data  |

```php
public function testAggregate()
{
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8]);

    $result = $collection->min();
    $this->assertEquals(1, $result);

    $result = $collection->max();
    $this->assertEquals(8, $result);

    $result = $collection->sum();
    $this->assertEquals(36, $result);

    $result = $collection->avg();
    $this->assertEquals(4.5, $result);

    $result = $collection->count();
    $this->assertEquals(8, $result);
}
```

### Reduce

-   Jika kita ingin membuat aggregate secara manual, kita bisa menggunakan function reduce
-   Reduce merupakan operasi yang dilakukan pada tiap data yang ada di collection secara sequential dan mengembalikan hasil
-   Hasil dari reduce sebelumnya akan digunakan di iterasi selanjutnya

| Method                        | Keterangan                                                                              |
| ----------------------------- | --------------------------------------------------------------------------------------- |
| reduce(function(carry, item)) | Pada iterasi pertama, carry akan bernilai data pertama, dan item adalah data sebelumnya |
|                               | Pada iterasi selanjutnya, carry adalah hasil dari iterasi sebelumnya                    |

```php
public function testReduce()
{
    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

    $result = $collection->reduce(fn ($carry, $item) => $carry + $item);
    $this->assertEquals(55, $result);

    // reduce(1,2) = 3
    // reduce(3,3) = 6
    // reduce(6,4) = 10
    // reduce(10,5) = 15
    // reduce(15,6) = 21
    // reduce(21,7) = 28
    // reduce(28,8) = 36
    // reduce(36,9) = 45
    // reduce(45,10) = 55
}
```

### Lazy Collection

-   Saat belajar PHP, kita pernah membuat Generator (Lazy Array / Iterable)
-   Di Laravel juga kita bisa membuat hal seperti itu, bernama Lazy Collection
-   Keuntungan menggunakan Lazy Collection adalah kita bisa melakukan manipulasi data besar, tanpa harus takut semua operasi dieksekusi sebelum dibutuhkan
-   Saat membuat Lazy Collection, kita perlu menggunakan PHP Generator
-   https://laravel.com/api/10.x/Illuminate/Support/LazyCollection.html

```php
public function testLazyCollection()
{
    $collection = LazyCollection::make(function () {
        $value = 0;

        while (true) {
            yield $value;
            $value++;
        }
    });

    $result = $collection->take(10);
    $this->assertEqualsCanonicalizing([0, 1, 2, 3, 4, 5, 6, 7, 8, 9], $result->all());
}
```
