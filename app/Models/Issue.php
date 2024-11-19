<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject', 'header_text', 'footer_text', 'links_html', 'sent_at', 'user_id',
    ];

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
