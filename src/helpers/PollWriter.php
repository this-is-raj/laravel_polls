<?php

namespace Inani\Larapoll\Helpers;

use Inani\Larapoll\Poll;
use Inani\Larapoll\Traits\PollWriterResults;
use Inani\Larapoll\Traits\PollWriterVoting;

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