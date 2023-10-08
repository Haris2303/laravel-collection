<?php

namespace Tests\Feature;

use App\Data\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    // Create Collection
    public function testCreateCollection()
    {
        $collection = collect([1, 2, 3, 5]);
        self::assertEqualsCanonicalizing([1, 2, 3, 5], $collection->all());
    }

    // For Each
    public function testForEach()
    {
        $collection = collect([1, 2, 3, 4, 5, 6]);
        foreach ($collection as $key => $value) {
            self::assertEquals($key + 1, $value);
        }
    }

    // Manipulation Collection
    public function testCrud()
    {
        $collection = collect([]);
        $collection->push(1, 2, 3, 4);
        self::assertEqualsCanonicalizing([1, 2, 3, 4], $collection->all());

        $result = $collection->pop();
        self::assertEquals(4, $result);
        self::assertEquals([1, 2, 3], $collection->all());
    }

    // Mapping
    public function testMap()
    {
        $collection = collect([1, 2, 3]);
        $result = $collection->map(fn ($item) => $item * 2);
        self::assertEqualsCanonicalizing([2, 4, 6], $result->all());
    }

    public function testMapInto()
    {
        $collection = collect(["Otong"]);
        $result = $collection->mapInto(Person::class);
        self::assertEquals([new Person("Otong")], $result->all());
    }

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

    // Zipping
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

    public function testConcat()
    {
        $collection1 = collect([1, 2, 3]);
        $collection2 = collect([4, 5, 6]);
        $collection3 = $collection1->concat($collection2);

        self::assertEquals([1, 2, 3, 4, 5, 6], $collection3->all());
    }

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

    // Flattening
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

    // String Representation
    public function testStringRepresentation()
    {
        $collection = collect(['Samsul', 'Udin', 'Jamal']);

        self::assertEquals('Samsul-Udin-Jamal', $collection->join('-'));
        self::assertEquals('Samsul-Udin_Jamal', $collection->join('-', '_'));
        self::assertEquals('Samsul, Udin dan Jamal', $collection->join(', ', ' dan '));
    }

    // Filtering
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

    public function testFilterIndex()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
        $result = $collection->filter(fn ($value, $key) => $value % 2 == 0);

        self::assertEqualsCanonicalizing([2, 4, 6, 8, 10], $result->all());
    }

    // Partitioning
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
}
