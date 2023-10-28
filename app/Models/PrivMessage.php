<?php

namespace App\Models;

use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrivMessage extends Model
{
    use BroadcastsEvents, HasFactory;

    protected $fillable = [
        'user_id',
        'priv_talk_id',
        'priv_message',
    ];

    /**
     * Get the user that the post belongs to.
     */
    public function privTalk(): BelongsTo
    {
        return $this->belongsTo(PrivTalk::class);
    }

    /**
     * Get the channels that model events should broadcast on.
     *
     * @return array<string, array<int, \Illuminate\Broadcasting\Channel|\Illuminate\Database\Eloquent\Model>>
     */
    public function broadcastOn(string $event): array
    {
        return match ($event) {
            'created' => [new PresenceChannel($this->privTalk->broadcastChannel())],
            default => [],
        };
    }
}
