<?php

namespace Raj\Larapoll;

use Illuminate\Database\Eloquent\Model;
use Raj\Larapoll\Traits\PollCreator;
use Raj\Larapoll\Traits\PollAccessor;
use Raj\Larapoll\Traits\PollManipulator;
use Raj\Larapoll\Traits\PollQueries;

class Poll extends Model
{
    use PollCreator, PollAccessor, PollManipulator, PollQueries;

    protected $fillable = ['question'];

    /**
     * A poll has many options related to
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    /**
     * Boot Method
     *
     */
    public static function boot()
    {
        parent::boot();
        static::deleting(function($poll) {
            $poll->options->each(function($option){
                Vote::where('option_id', $option->id)->delete();
            });
            $poll->options()->delete();
        });
    }

    /**
     * Get all of the votes for the poll.
     */
    public function votes()
    {
        return $this->hasManyThrough(Vote::class, Option::class);
    }
}
