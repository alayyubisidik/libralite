<?php

namespace Database\Factories;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Attendance::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => Member::factory()->member(),
            'check_in_date' => fake()->unique()->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
            'check_in_time' => fake()->time('H:i:s'),
            'status' => AttendanceStatus::Present,
        ];
    }
}
