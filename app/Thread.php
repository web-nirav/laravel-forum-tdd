<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

    /**
     * setting a global query scope to fetch replies count for each thread
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function($builder){
            $builder->withCount('replies');
        });
    }
    
    /**
     * Get a string path for the thread.
     *
     * @return string
     */
    public function path()
    {
        return route('threads.channel.show', [$this->channel->name, $this->id]);
    }

    /**
     * A thread may have many replies
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * A thread belongs to a creator.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A thread belongs to a channel.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Add a reply to the thread
     *
     * @param $reply
     */
    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    /* public function getReplyCountAttribute()
    {
        return $this->replies()->count();
    } */
}
