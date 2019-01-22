<?php

namespace Raj\LaravelPoll\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Raj\LaravelPoll\Helpers\PollHandler;
use Raj\LaravelPoll\Http\Request\PollCreationRequest;
use Raj\LaravelPoll\Poll;

class PollManagerController extends Controller
{

    /**
     *  Constructor
     *
     */
    public function __construct()
    {
        $this->middleware( config('laravel_poll_config.admin_auth') );
    }

    public function home()
    {
        return view('laravel_poll::dashboard.home');
    }
    /**
     * Show all the Polls in the database
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $polls = Poll::withCount('options', 'votes')->latest()->paginate(
            config('laravel_poll_config.pagination')
        );
        return view('laravel_poll::dashboard.index', compact('polls'));
    }

    /**
     * Store the Request
     *
     * @param PollCreationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PollCreationRequest $request)
    {
        $poll = PollHandler::createFromRequest($request->all());
        return redirect(route('poll.index'))
            ->with('success', 'Your poll has been addedd successfully');
    }

    /**
     * Show the poll to be prepared to edit
     *
     * @param Poll $poll
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Poll $poll)
    {
        return view('laravel_poll::dashboard.edit', compact('poll'));
    }

    /**
     * Update the Poll
     *
     * @param Poll $poll
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Poll $poll, Request $request)
    {
        PollHandler::modify($poll, $request->all());

        return redirect(route('poll.index'))
            ->with('success', 'Your poll has been updated successfully');
    }

    /**
     * Delete a Poll
     *
     * @param Poll $poll
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Poll $poll)
    {
        $poll->remove();

        return redirect(route('poll.index'))
            ->with('success', 'Your poll has been deleted successfully');
    }
    public function create()
    {
        return view('laravel_poll::dashboard.create');
    }

    /**
     * Lock a Poll
     *
     * @param Poll $poll
     * @return \Illuminate\Http\RedirectResponse
     */
    public function lock(Poll $poll)
    {
        $poll->lock();
        return redirect(route('poll.index'))
            ->with('success', 'Your poll has been locked successfully');
    }

    /**
     * Unlock a Poll
     *
     * @param Poll $poll
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlock(Poll $poll)
    {
        $poll->unLock();
        return redirect(route('poll.index'))
            ->with('success', 'Your poll has been unlocked successfully');
    }
}
