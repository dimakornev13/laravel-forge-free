<?php

namespace Database\Factories;

use App\Models\LogEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogEventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LogEvent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => rand(LogEvent::TYPE_ERROR, LogEvent::TYPE_SUCCESS),
            'content' => $this->faker->text
        ];
    }
}
