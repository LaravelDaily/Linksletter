<?php

namespace Database\Factories;

use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LinkFactory extends Factory
{
    protected $model = Link::class;

    public function definition()
    {
        return [
            'url' => $this->faker->url(),
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'position' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            // Disabled for now, since we don't have issues workflow yet
//            'issue_id' => Issue::factory(),
            'user_id' => User::factory(),
        ];
    }
}
