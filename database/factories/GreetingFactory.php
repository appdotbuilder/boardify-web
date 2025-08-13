<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Event;
use App\Models\Greeting;
use App\Models\GreetingTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Greeting>
 */
class GreetingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Greeting>
     */
    protected $model = Greeting::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $displayDuration = $this->faker->randomElement([3, 5, 7]);
        $amount = $displayDuration * 2.50; // Base pricing: $2.50 per second
        
        $messages = [
            'Happy Birthday! Wishing you all the best on your special day!',
            'Congratulations on your wedding! May your love story be filled with happiness.',
            'Congratulations on your graduation! Your hard work has paid off.',
            'Happy Anniversary! Here\'s to many more years of love and happiness.',
            'Wishing you success and happiness in all your endeavors!',
            'Thank you for being such an amazing friend. You deserve all the best!',
            'Sending you love and best wishes on this special occasion.',
            'May this special day bring you joy, love, and wonderful memories.',
        ];

        return [
            'event_id' => Event::factory(),
            'customer_id' => Customer::factory(),
            'template_id' => GreetingTemplate::factory(),
            'custom_message' => $this->faker->randomElement($messages),
            'sender_name' => $this->faker->name(),
            'display_duration' => $displayDuration,
            'amount' => $amount,
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
            'payment_id' => $this->faker->optional(0.7)->uuid(),
            'payment_details' => $this->faker->optional(0.7)->randomElements([
                'transaction_id' => $this->faker->uuid(),
                'payment_method' => $this->faker->randomElement(['credit_card', 'bank_transfer', 'e_wallet']),
                'amount' => $amount,
                'currency' => 'IDR',
                'status' => 'paid',
            ]),
            'is_displayed' => $this->faker->boolean(30),
            'displayed_at' => $this->faker->optional(0.3)->dateTimeThisMonth(),
        ];
    }

    /**
     * Indicate that the greeting is paid.
     *
     * @return static
     */
    public function paid()
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => 'paid',
            'payment_id' => $this->faker->uuid(),
            'payment_details' => [
                'transaction_id' => $this->faker->uuid(),
                'payment_method' => $this->faker->randomElement(['credit_card', 'bank_transfer', 'e_wallet']),
                'amount' => $attributes['amount'],
                'currency' => 'IDR',
                'status' => 'paid',
            ],
        ]);
    }

    /**
     * Indicate that the greeting is pending payment.
     *
     * @return static
     */
    public function pending()
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => 'pending',
            'payment_id' => null,
            'payment_details' => null,
        ]);
    }
}