<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this -> call( AccountsTableSeeder::class );
        $this -> call( UsersTableSeeder::class );
        $this -> call( ActorsTableSeeder::class );
        $this -> call( MediasTableSeeder::class );
        $this -> call( MediaActorTableSeeder::class );
    }
}
