<?php

use App\Eloquents\EloquentUser;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(EloquentUser::class, 10)->create();
    }
}
