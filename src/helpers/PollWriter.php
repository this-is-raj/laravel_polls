<?php

namespace Raj\Larapoll\Helpers;

use Raj\Larapoll\Poll;
use Raj\Larapoll\Traits\PollWriterResults;
use Raj\Larapoll\Traits\PollWriterVoting;

class PollWriter {
    use PollWriterResults,
        PollWriterVoting;
    /**
     * Draw a Poll
     *
     * @param $poll_id
     * @param $voter
     */
    public function draw($poll_id, $voter)
    {
        $poll = Poll::findOrFail($poll_id);
        $this->showFeedBack();
        if($voter->hasVoted($poll_id) || $poll->isLocked()){
            return $this->drawResult($poll);
        }

        if($poll->isRadio()){
            return $this->drawRadio($poll);
        }
        return $this->drawCheckbox($poll);
    }
}
