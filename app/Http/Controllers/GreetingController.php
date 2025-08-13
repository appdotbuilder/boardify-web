<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGreetingRequest;
use App\Models\Event;
use App\Models\Greeting;
use App\Models\GreetingTemplate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GreetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $query = Greeting::with(['event', 'customer.user', 'template']);

        if ($user->hasRole('customer')) {
            $query->whereHas('customer', fn($q) => $q->where('user_id', $user->id));
        }

        $greetings = $query->latest()->paginate(10);

        return Inertia::render('greetings/index', [
            'greetings' => $greetings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        $templates = GreetingTemplate::active()->get();

        return Inertia::render('greetings/create', [
            'event' => $event,
            'templates' => $templates,
            'pricing' => [
                3 => 7500,  // 3 seconds = IDR 7,500
                5 => 12500, // 5 seconds = IDR 12,500
                7 => 17500, // 7 seconds = IDR 17,500
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGreetingRequest $request)
    {
        $user = auth()->user();
        $customer = $user->customer;

        if (!$customer) {
            return back()->withErrors(['error' => 'Only customers can create greetings.']);
        }

        $pricing = [3 => 7500, 5 => 12500, 7 => 17500];
        $amount = $pricing[$request->display_duration];

        $greeting = Greeting::create([
            ...$request->validated(),
            'customer_id' => $customer->id,
            'amount' => $amount,
            'payment_status' => 'pending',
        ]);

        // In a real application, redirect to Midtrans payment gateway
        return redirect()->route('greetings.payment', $greeting)
            ->with('success', 'Greeting created! Please complete payment to display your message.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Greeting $greeting)
    {
        $greeting->load(['event', 'customer.user', 'template']);

        return Inertia::render('greetings/show', [
            'greeting' => $greeting,
        ]);
    }


}