<?php

namespace App\Http\Controllers;

use App\Models\Greeting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    /**
     * Display the payment page for a greeting.
     */
    public function show(Greeting $greeting)
    {
        return Inertia::render('greetings/payment', [
            'greeting' => $greeting->load(['event', 'template']),
        ]);
    }

    /**
     * Process payment for a greeting.
     */
    public function store(Request $request, Greeting $greeting)
    {
        // Mock payment processing - in real app, integrate with Midtrans
        $greeting->update([
            'payment_status' => 'paid',
            'payment_id' => 'MOCK_' . uniqid(),
            'payment_details' => [
                'transaction_id' => 'TXN_' . uniqid(),
                'payment_method' => 'mock_payment',
                'amount' => $greeting->amount,
                'currency' => 'IDR',
                'status' => 'paid',
                'paid_at' => now(),
            ],
        ]);

        return redirect()->route('greetings.show', $greeting)
            ->with('success', 'Payment successful! Your greeting will be displayed during the event.');
    }
}