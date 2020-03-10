<?php

use App\Eloquents\EloquentTag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(EloquentTag::class, 20)->create();
    }
}
