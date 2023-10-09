<?php

namespace Tests\Feature;

use App\Data\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\LazyCollection;
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

    // Testing
    public function testTesting()
    {
        $collection = collect(['Udin', 'Samsul', 'Ucup']);
        self::assertTrue($collection->contains('Udin'));
        self::assertTrue($collection->contains(fn ($value, $key) => $value == "Samsul"));
    }

    // Grouping
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

    // Slicing
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

    // Take and Skip
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

    // Chunked
    public function testChunk()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8]);

        $result = $collection->chunk(3);
        self::assertEqualsCanonicalizing([1, 2, 3], $result[0]->all());
        self::assertEqualsCanonicalizing([4, 5, 6], $result[1]->all());
        self::assertEqualsCanonicalizing([7, 8], $result[2]->all());
    }

    // Retrieve
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

    // Random
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

    // Checking
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

    // Ordering
    public function testOrdering()
    {
        $collection = collect([1, 3, 5, 7, 6, 2, 9]);

        $result = $collection->sort();
        $this->assertEqualsCanonicalizing([1, 2, 3, 5, 7, 6, 9], $result->all());

        $result = $collection->sortDesc();
        $this->assertEqualsCanonicalizing([9, 7, 6, 5, 3, 2, 1], $result->all());
    }

    // Aggregate
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

    // Reduce
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
}
