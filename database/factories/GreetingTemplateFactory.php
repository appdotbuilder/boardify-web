<?php

namespace Database\Factories;

use App\Models\GreetingTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GreetingTemplate>
 */
class GreetingTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\GreetingTemplate>
     */
    protected $model = GreetingTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['birthday', 'wedding', 'graduation', 'anniversary', 'general'];
        $category = $this->faker->randomElement($categories);
        
        $templates = [
            'birthday' => ['Happy Birthday Classic', 'Birthday Celebration', 'Birthday Wishes'],
            'wedding' => ['Wedding Bliss', 'Wedding Celebration', 'Congratulations Wedding'],
            'graduation' => ['Graduation Achievement', 'Graduation Success', 'Congratulations Graduate'],
            'anniversary' => ['Anniversary Love', 'Happy Anniversary', 'Anniversary Celebration'],
            'general' => ['Elegant Card', 'Simple Greeting', 'Classic Design'],
        ];

        $colors = ['blue', 'pink', 'gold', 'green', 'purple', 'red'];
        
        return [
            'name' => $this->faker->randomElement($templates[$category]),
            'description' => $this->faker->sentence(),
            'preview_image' => '/images/templates/' . strtolower(str_replace(' ', '-', $this->faker->randomElement($templates[$category]))) . '.jpg',
            'design_config' => [
                'background_color' => $this->faker->randomElement($colors),
                'text_color' => 'white',
                'font_family' => $this->faker->randomElement(['Arial', 'Georgia', 'Times New Roman', 'Helvetica']),
                'font_size' => $this->faker->randomElement([16, 18, 20, 22, 24]),
                'layout' => $this->faker->randomElement(['center', 'left', 'right']),
                'animation' => $this->faker->randomElement(['fade', 'slide', 'zoom', 'bounce']),
            ],
            'category' => $category,
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }

    /**
     * Indicate that the template is active.
     *
     * @return static
     */
    public function active()
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Set template for birthday category.
     *
     * @return static
     */
    public function birthday()
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'birthday',
            'name' => $this->faker->randomElement(['Happy Birthday Classic', 'Birthday Celebration', 'Birthday Wishes']),
        ]);
    }

    /**
     * Set template for wedding category.
     *
     * @return static
     */
    public function wedding()
    {
        return $this->state(fn (array $attributes) => [
            'category' => 'wedding',
            'name' => $this->faker->randomElement(['Wedding Bliss', 'Wedding Celebration', 'Congratulations Wedding']),
        ]);
    }
}