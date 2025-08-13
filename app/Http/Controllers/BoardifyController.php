<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\GreetingTemplate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BoardifyController extends Controller
{
    /**
     * Display the main Boardify page.
     */
    public function index()
    {
        $activeEvents = Event::active()
            ->with(['partner.user', 'greetings'])
            ->where('registration_start', '<=', now())
            ->where('registration_end', '>=', now())
            ->orderBy('event_date')
            ->limit(6)
            ->get();

        $featuredTemplates = GreetingTemplate::active()
            ->limit(8)
            ->get();

        return Inertia::render('welcome', [
            'activeEvents' => $activeEvents,
            'featuredTemplates' => $featuredTemplates,
            'stats' => [
                'totalEvents' => Event::active()->count(),
                'totalTemplates' => GreetingTemplate::active()->count(),
                'activeGreetings' => \App\Models\Greeting::where('payment_status', 'paid')->count(),
            ],
        ]);
    }

    /**
     * Display events page.
     */
    public function show($type = 'events')
    {
        if ($type === 'events') {
            $events = Event::active()
                ->with(['partner.user', 'greetings'])
                ->where('registration_start', '<=', now())
                ->where('registration_end', '>=', now())
                ->orderBy('event_date')
                ->paginate(12);

            return Inertia::render('boardify/events', [
                'events' => $events,
            ]);
        }

        if ($type === 'templates') {
            $templates = GreetingTemplate::active()
                ->orderBy('category')
                ->paginate(16);

            return Inertia::render('boardify/templates', [
                'templates' => $templates,
            ]);
        }

        return redirect()->route('home');
    }
}