<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $guarded = [];

    /**
     * {@inheritDoc}
     */
    protected $dates = ['started_at', 'stopped_at'];

    /**
     * {@inheritDoc}
     */
    protected $with = ['user'];

    /**
     * Get associated user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timers()
    {
        return $this->hasMany(Timer::class);
    }

}
