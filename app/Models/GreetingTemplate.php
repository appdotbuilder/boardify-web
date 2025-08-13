<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\GreetingTemplate
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $preview_image
 * @property array $design_config
 * @property string $category
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Greeting> $greetings
 * @property-read int|null $greetings_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|GreetingTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GreetingTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GreetingTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|GreetingTemplate whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GreetingTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GreetingTemplate whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GreetingTemplate whereDesignConfig($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GreetingTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GreetingTemplate whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GreetingTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GreetingTemplate wherePreviewImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GreetingTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GreetingTemplate active()
 * @method static \Database\Factories\GreetingTemplateFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class GreetingTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'preview_image',
        'design_config',
        'category',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'design_config' => 'array',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the greetings that use this template.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function greetings(): HasMany
    {
        return $this->hasMany(Greeting::class, 'template_id');
    }

    /**
     * Scope a query to only include active templates.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}