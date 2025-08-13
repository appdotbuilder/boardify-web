<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\EventRequest;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventRequest>
 */
class EventRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\EventRequest>
     */
    protected $model = EventRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $eventNames = [
            'Birthday Party for Sarah',
            'Wedding Reception',
            'Company Annual Meeting',
            'Graduation Celebration',
            'Product Launch Event',
            'Charity Fundraiser',
            'Art Exhibition Opening',
            'Music Concert',
        ];

        return [
            'customer_id' => Customer::factory(),
            'event_name' => $this->faker->randomElement($eventNames),
            'event_description' => $this->faker->paragraph(),
            'location' => $this->faker->address(),
            'preferred_date' => $this->faker->dateTimeBetween('+1 week', '+2 months'),
            'additional_notes' => $this->faker->optional(0.6)->paragraph(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'assigned_partner_id' => $this->faker->optional(0.4)->randomElement([null, Partner::factory()]),
            'processed_by' => $this->faker->optional(0.4)->randomElement([null, User::factory()]),
            'admin_notes' => $this->faker->optional(0.3)->sentence(),
            'processed_at' => $this->faker->optional(0.4)->dateTimeThisMonth(),
        ];
    }

    /**
     * Indicate that the request is pending.
     *
     * @return static
     */
    public function pending()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'assigned_partner_id' => null,
            'processed_by' => null,
            'admin_notes' => null,
            'processed_at' => null,
        ]);
    }

    /**
     * Indicate that the request is approved.
     *
     * @return static
     */
    public function approved()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'assigned_partner_id' => Partner::factory(),
            'processed_by' => User::factory(),
            'admin_notes' => $this->faker->sentence(),
            'processed_at' => $this->faker->dateTimeThisMonth(),
        ]);
    }
}