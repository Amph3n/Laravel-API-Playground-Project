<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chirp extends Model
{
    use HasFactory;

    // This prevents users from accessing database data, that they're not permitted to 
    protected $fillable = [
        'message',
    ];

    public function user(): BelongsTo {

        return $this->belongsTo(User::class);
    }
}
