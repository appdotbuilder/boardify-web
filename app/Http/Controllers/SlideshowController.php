<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Inertia\Inertia;

class SlideshowController extends Controller
{
    /**
     * Display the slideshow for an event.
     */
    public function show(Event $event)
    {
        $greetings = $event->greetings()
            ->where('payment_status', 'paid')
            ->with(['customer.user', 'template'])
            ->orderBy('created_at')
            ->get();

        return Inertia::render('events/slideshow', [
            'event' => $event,
            'greetings' => $greetings,
        ]);
    }
}