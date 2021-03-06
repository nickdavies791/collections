<?php

use Tests\TestCase;

class CartTest extends TestCase
{
    /**
     * @test
     */
    public function get_total_price_of_all_items_in_cart_in_pence()
    {
        $items = collect($this->load('cart.json'));

        $total = $items->reduce(function ($total, $item) {
            return $total + ($item->price * $item->quantity) / 100;
        });

        $this->assertEquals(13.73, $total);
    }

    /**
     * @test
     */
    public function get_total_number_of_items_in_each_aisle()
    {
        $items = collect($this->load('cart.json'));

        $count = $items->groupBy('aisle')->map(function ($item) {
            return $item->count();
        })->all();

        $this->assertEquals([
            'Fruit' => 2,
            'Dairy' => 1,
            'Bakery' => 1,
            'Vegetable' => 2,
        ], $count);
    }

    /**
     * @test
     */
    public function get_most_expensive_item_in_cart()
    {
        $items = collect($this->load('cart.json'));

        $mostExpensiveItem = $items->max('price');

        $this->assertEquals(140, $mostExpensiveItem);
    }

    /**
     * @test
     */
    public function get_cheapest_item_in_cart()
    {
        $items = collect($this->load('cart.json'));

        $cheapestItem = $items->min('price');

        $this->assertEquals(39, $cheapestItem);
    }

    /**
     * @test
     */
    public function get_the_average_number_of_items_in_the_cart()
    {
        $items = collect($this->load('cart.json'));

        $avg = $items->pluck('quantity')->avg();

        $this->assertEquals(3.6666666666667, $avg);
    }

    /**
     * @test
     */
    public function compare_cart_to_another_cart()
    {
        $cartA = collect([
            'id' => 1,
            'product' => 'Tomato',
            'aisle' => 'Fruit',
            'price' => 40,
            'quantity' => 8
        ]);
        $cartB = collect([
            'id' => 1,
            'product' => 'Oranges',
            'aisle' => 'Fruit',
            'price' => 40,
            'quantity' => 4
        ]);

        $this->assertEquals([
            'product' => 'Tomato',
            'quantity' => 8
        ], $cartA->diff($cartB)->all());
    }

    /**
     * @test
     */
    public function split_cart_into_items_less_than_100_pence_and_items_greater_than_100_pence_in_price_order()
    {
        $items = collect($this->load('cart.json'));

        list($cheap, $expensive) = $items->sortBy('price')
            ->partition(function ($item) { return $item->price < 100; })->all();

        $this->assertCount(4, $cheap);
        $this->assertCount(2, $expensive);
    }
}