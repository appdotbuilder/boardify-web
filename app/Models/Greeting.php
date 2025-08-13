<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Greeting
 *
 * @property int $id
 * @property int $event_id
 * @property int $customer_id
 * @property int $template_id
 * @property string $custom_message
 * @property string $sender_name
 * @property int $display_duration
 * @property string $amount
 * @property string $payment_status
 * @property string|null $payment_id
 * @property array|null $payment_details
 * @property bool $is_displayed
 * @property \Illuminate\Support\Carbon|null $displayed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Event $event
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\GreetingTemplate $template
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting whereCustomMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting whereDisplayDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting whereDisplayedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting whereIsDisplayed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting wherePaymentDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting whereSenderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Greeting paid()
 * @method static \Database\Factories\GreetingFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Greeting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'event_id',
        'customer_id',
        'template_id',
        'custom_message',
        'sender_name',
        'display_duration',
        'amount',
        'payment_status',
        'payment_id',
        'payment_details',
        'is_displayed',
        'displayed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'display_duration' => 'integer',
        'payment_details' => 'array',
        'is_displayed' => 'boolean',
        'displayed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the event that owns the greeting.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the customer that owns the greeting.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the template that the greeting uses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(GreetingTemplate::class, 'template_id');
    }

    /**
     * Scope a query to only include paid greetings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }
}