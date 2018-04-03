<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = ['1','2','3'];
        $faker = app(Faker\Generator::class);

        $statuses = factory(Status::class)->times(100)->make()->each(function($status) use ($userIds, $faker) {
            $status->user_id = $faker->randomElement($userIds);
        });
        Status::insert($statuses->toArray());
    }
}
