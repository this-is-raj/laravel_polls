<?php

namespace Raj\LaravelPoll\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Raj\LaravelPoll\Helpers\PollHandler;
use Raj\LaravelPoll\Http\Request\AddOptionsRequest;
use Raj\LaravelPoll\Poll;

class OptionManagerController extends Controller
{

    /**
     *  Constructor
     *
     */
    public function __construct()
    {
        $this->middleware( config('laravel_poll_config.admin_auth') );
    }

    /**
     * Add new options to the poll
     *
     * @param Poll $poll
     * @param AddOptionsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Poll $poll, AddOptionsRequest $request)
    {
        $poll->attach($request->get('options'));

        return redirect(route('poll.index'))
            ->with('success', 'New poll options have been added successfully');
    }

    /**
     * Remove the Selected Option
     *
     * @param Poll $poll
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Poll $poll, Request $request)
    {
        try{
            $poll->detach($request->get('options'));
            return redirect(route('poll.index'))
                ->with('success', 'Poll options have been removed successfully');
        }catch (\Exception $e){
            $message = PollHandler::getMessage($e);

            return back()
                ->withErrors($message);
        }
    }

    /**
     * Page to add new options
     *
     * @param Poll $poll
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function push(Poll $poll)
    {
        return view('laravel_poll::dashboard.options.push', compact('poll'));
    }

    /**
     * Page to delete Options
     *
     * @param Poll $poll
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Poll $poll)
    {
        return view('laravel_poll::dashboard.options.remove', compact('poll'));
    }
}
