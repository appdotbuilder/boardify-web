<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Event>
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $eventDate = $this->faker->dateTimeBetween('+1 week', '+2 months');
        $registrationStart = $this->faker->dateTimeBetween('now', $eventDate);
        $registrationEnd = $this->faker->dateTimeBetween($registrationStart, $eventDate);

        return [
            'name' => $this->faker->randomElement([
                'John & Sarah Wedding',
                'Tech Conference 2024',
                'University Graduation',
                'Corporate Annual Meeting',
                'Birthday Celebration',
                'Anniversary Party',
                'Charity Gala Event'
            ]),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->address(),
            'event_date' => $eventDate,
            'registration_start' => $registrationStart,
            'registration_end' => $registrationEnd,
            'status' => $this->faker->randomElement(['draft', 'active', 'completed']),
            'partner_id' => Partner::factory(),
            'created_by' => User::factory(),
        ];
    }

    /**
     * Indicate that the event is active.
     *
     * @return static
     */
    public function active()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the event is upcoming.
     *
     * @return static
     */
    public function upcoming()
    {
        $eventDate = $this->faker->dateTimeBetween('+1 day', '+1 month');
        
        return $this->state(fn (array $attributes) => [
            'event_date' => $eventDate,
            'registration_start' => now(),
            'registration_end' => $this->faker->dateTimeBetween('now', $eventDate),
            'status' => 'active',
        ]);
    }
}