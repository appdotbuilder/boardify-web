<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Event;
use App\Models\EventRequest;
use App\Models\Greeting;
use App\Models\GreetingTemplate;
use App\Models\Partner;
use App\Models\User;
use App\Models\UserRole;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@boardify.com',
        ]);
        UserRole::factory()->admin()->create(['user_id' => $adminUser->id]);

        // Create test customer
        $customerUser = User::factory()->create([
            'name' => 'John Customer',
            'email' => 'customer@boardify.com',
        ]);
        UserRole::factory()->customer()->create(['user_id' => $customerUser->id]);
        Customer::factory()->create(['user_id' => $customerUser->id]);

        // Create test partner
        $partnerUser = User::factory()->create([
            'name' => 'Sarah Partner',
            'email' => 'partner@boardify.com',
        ]);
        UserRole::factory()->partner()->create(['user_id' => $partnerUser->id]);
        $partner = Partner::factory()->buildingOwner()->create(['user_id' => $partnerUser->id]);

        // Create more users with random roles
        $users = User::factory(20)->create();
        
        foreach ($users as $user) {
            $role = fake()->randomElement(['customer', 'partner', 'admin']);
            UserRole::factory()->create([
                'user_id' => $user->id,
                'role' => $role,
            ]);

            if ($role === 'customer') {
                Customer::factory()->create(['user_id' => $user->id]);
            } elseif ($role === 'partner') {
                Partner::factory()->create(['user_id' => $user->id]);
            }
        }

        // Create greeting templates
        GreetingTemplate::factory(15)->active()->create();
        
        // Add specific templates for different categories
        GreetingTemplate::factory()->birthday()->active()->create([
            'name' => 'Happy Birthday Balloons',
            'description' => 'Colorful birthday template with balloons and confetti',
        ]);
        
        GreetingTemplate::factory()->wedding()->active()->create([
            'name' => 'Wedding Elegance',
            'description' => 'Elegant wedding template with roses and rings',
        ]);

        // Create events
        $partners = Partner::all();
        Event::factory(10)->active()->create([
            'partner_id' => $partners->random()->id,
            'created_by' => $adminUser->id,
        ]);

        // Create upcoming events for greeting submissions
        $upcomingEvents = Event::factory(5)->upcoming()->create([
            'partner_id' => $partners->random()->id,
            'created_by' => $adminUser->id,
        ]);

        // Create greetings for events
        $customers = Customer::all();
        $templates = GreetingTemplate::active()->get();
        
        foreach ($upcomingEvents as $event) {
            Greeting::factory(random_int(3, 8))->paid()->create([
                'event_id' => $event->id,
                'customer_id' => $customers->random()->id,
                'template_id' => $templates->random()->id,
            ]);
            
            // Add some pending greetings
            Greeting::factory(random_int(1, 3))->pending()->create([
                'event_id' => $event->id,
                'customer_id' => $customers->random()->id,
                'template_id' => $templates->random()->id,
            ]);
        }

        // Create event requests
        EventRequest::factory(8)->pending()->create([
            'customer_id' => $customers->random()->id,
        ]);
        
        EventRequest::factory(5)->approved()->create([
            'customer_id' => $customers->random()->id,
            'processed_by' => $adminUser->id,
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin@boardify.com');
        $this->command->info('Customer: customer@boardify.com');
        $this->command->info('Partner: partner@boardify.com');
        $this->command->info('Password: password');
    }
}
