<?php

use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * @test
     */
    public function get_total_number_of_users()
    {
        $users = collect($this->load('users.json'));

        $this->assertEquals(5, $users->count());
    }

    /**
     * @test
     */
    public function get_joined_emails_of_all_employees()
    {
        $users = collect($this->load('users.json'));

        $sales = $users->reduce(function ($email, $user) {
            return $email . $user->email . ',';
        });

        $this->assertEquals(
            'john@example.com,jane@example.com,jim@example.com,james@example.com,jill@example.com,'
        , $sales);
    }

    /**
     * @test
     */
    public function get_total_salary_of_full_time_employees()
    {
        $users = collect($this->load('users.json'));

        $totalSalary = $users->filter(function ($user) {
            return $user->employment->type == 'Full Time';
        })->pluck('salary')->sum();

        $this->assertEquals(61700, $totalSalary);
    }

    /**
     * @test
     */
    public function get_user_names_and_departments()
    {
        $users = collect($this->load('users.json'));

        $namesAndDepartments = $users->map(function ($user) {
            return [$user->forename . ' ' . $user->surname => $user->department];
        })->all();

        $this->assertEquals([
            ['John Doe' => 'Sales'],
            ['Jane Doe' => 'Sales'],
            ['Jim Doe' => 'Technical'],
            ['James Doe' => 'Marketing'],
            ['Jill Doe' => 'Finance']
        ], $namesAndDepartments);
    }

    /**
     * @test
     */
    public function get_user_emails_as_key_and_user_forename_as_value()
    {
        $users = collect($this->load('users.json'));

        $emails = $users->mapWithKeys(function ($user) {
            return [$user->email => $user->forename];
        })->all();

        $this->assertEquals([
            'john@example.com' => 'John',
            'jane@example.com' => 'Jane',
            'jim@example.com' => 'Jim',
            'james@example.com' => 'James',
            'jill@example.com' => 'Jill'
        ], $emails);
    }

    /**
     * @test
     */
    public function get_total_length_of_surname_for_all_users()
    {
        $users = collect($this->load('users.json'));

        $length = $users->map(function ($user) {
            return strlen($user->surname);
        })->sum();

        $this->assertEquals(15, $length);
    }

    /**
     * @test
     */
    public function get_part_time_employees()
    {
        $users = collect($this->load('users.json'));

        $partTime = $users->filter(function ($user) {
            return $user->employment->type == 'Part Time';
        })->all();

        $this->assertCount(3, $partTime);
    }

    /**
     * @test
     */
    public function get_start_year_for_all_employees()
    {
        $users = collect($this->load('users.json'));

        $startYears = $users->map(function ($user) {
            return (new DateTime($user->employment->start))->format('Y');
        })->all();

        $this->assertEquals([
            '2012',
            '2010',
            '2018',
            '2019',
            '2014'
        ], $startYears);
    }

    /**
     * @test
     */
    public function get_start_day_for_all_employees()
    {
        $users = collect($this->load('users.json'));

        $startDays = $users->map(function ($user) {
            return (new DateTime($user->employment->start))->format('l');
        })->all();

        $this->assertEquals([
            'Sunday',
            'Tuesday',
            'Friday',
            'Thursday',
            'Tuesday'
        ], $startDays);
    }

    /**
     * @test
     */
    public function get_users_email_addresses_with_an_end_date()
    {
        $users = collect($this->load('users.json'));

        $emails = $users->filter(function ($user) {
            return $user->employment->end !== null;
        })->pluck('email')->all();

        $this->assertEquals([
            'john@example.com'
        ], $emails);
    }

    /**
     * @test
     */
    public function get_employees_in_the_sales_department()
    {
        $users = collect($this->load('users.json'));

        $salesEmployees = $users->filter(function ($user) {
            return $user->department == 'Sales';
        });

        $this->assertCount(2, $salesEmployees);
    }

    /**
     * @test
     */
    public function get_emails_of_all_employees_in_the_marketing_department()
    {
        $users = collect($this->load('users.json'));

        $emails = $users->filter(function ($user) {
            return $user->department == 'Marketing';
        })->pluck('email')->all();

        $this->assertEquals([
            'james@example.com'
        ], $emails);
    }

    /**
     * @test
     */
    public function get_all_employees_who_earn_between_20000_and_30000()
    {
        $users = collect($this->load('users.json'));

        $salaries = $users->whereBetween('salary', [20000, 30000]);

        $this->assertCount(2, $salaries);
    }

    /**
     * @test
     */
    public function get_number_of_employees_in_each_department()
    {
        $users = collect($this->load('users.json'));

        $count = $users->groupBy('department')->map(function ($department) {
            return $department->count();
        })->all();

        $this->assertEquals([
            'Sales' => 2,
            'Technical' => 1,
            'Marketing' => 1,
            'Finance' => 1,
        ], $count);
    }

    /**
     * @test
     */
    public function get_the_most_valuable_customer()
    {
        $users = collect($this->load('users.json'));

        $customer = $users->filter(function ($user) {
            return $user->department == 'Sales';
        })->pluck('sales')->flatten()->groupBy('customer')->map(function ($sales) {
            return $sales->sum('quantity') * $sales->sum('unit_price');
        })->sort()->reverse()->keys()->first();

        $this->assertEquals('Mega Toys Corp', $customer);
    }

    /**
     * @test
     */
    public function a_user_can_be_mapped_into_a_User_class()
    {
        $users = collect($this->load('users.json'));

        $users = $users->mapInto(User::class);

        dd($users->all());
    }
}


class User {
    //
}