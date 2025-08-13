<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\EventRequest
 *
 * @property int $id
 * @property int $customer_id
 * @property string $event_name
 * @property string|null $event_description
 * @property string $location
 * @property \Illuminate\Support\Carbon $preferred_date
 * @property string|null $additional_notes
 * @property string $status
 * @property int|null $assigned_partner_id
 * @property int|null $processed_by
 * @property string|null $admin_notes
 * @property \Illuminate\Support\Carbon|null $processed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\Partner|null $assignedPartner
 * @property-read \App\Models\User|null $processor
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest whereAdditionalNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest whereAdminNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest whereAssignedPartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest whereEventDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest whereEventName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest wherePreferredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest whereProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest whereProcessedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRequest pending()
 * @method static \Database\Factories\EventRequestFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class EventRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'customer_id',
        'event_name',
        'event_description',
        'location',
        'preferred_date',
        'additional_notes',
        'status',
        'assigned_partner_id',
        'processed_by',
        'admin_notes',
        'processed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'preferred_date' => 'datetime',
        'processed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the customer that made the request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the partner assigned to the request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedPartner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'assigned_partner_id');
    }

    /**
     * Get the user who processed the request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Scope a query to only include pending requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}