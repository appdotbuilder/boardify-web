<?php

namespace Database\Factories;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partner>
 */
class PartnerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Partner>
     */
    protected $model = Partner::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = $this->faker->randomElement(['individual', 'building_owner']);
        
        return [
            'user_id' => User::factory(),
            'category' => $category,
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'location_name' => $category === 'building_owner' ? $this->faker->company() . ' Building' : null,
            'location_types' => $category === 'building_owner' 
                ? $this->faker->randomElements(['university', 'wedding', 'funeral', 'corporate', 'mall'], random_int(1, 3))
                : null,
        ];
    }

    /**
     * Indicate that the partner is an individual.
     *
     * @return static
     */
    public function individual()
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'individual',
            'location_name' => null,
            'location_types' => null,
        ]);
    }

    /**
     * Indicate that the partner is a building owner.
     *
     * @return static
     */
    public function buildingOwner()
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'building_owner',
            'location_name' => $this->faker->company() . ' Building',
            'location_types' => $this->faker->randomElements(['university', 'wedding', 'funeral', 'corporate', 'mall'], random_int(1, 3)),
        ]);
    }
}