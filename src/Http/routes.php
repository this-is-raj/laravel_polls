<?php

$prefix = config('larapoll_config.prefix');

Route::group(['namespace' => 'Inani\Larapoll\Http\Controllers', 'prefix' => $prefix], function(){
    Route::get('/admin', ['uses' => 'PollManagerController@home', 'as' => 'poll.home']);
    Route::get('/admin/polls', ['uses' => 'PollManagerController@index', 'as' => 'poll.index']);
    Route::get('/admin/polls/create', ['uses' => 'PollManagerController@create', 'as' => 'poll.create']);
    Route::get('/admin/polls/{poll}', ['uses' => 'PollManagerController@edit', 'as' => 'poll.edit']);
    Route::post('/admin/polls/{poll}', ['uses' => 'PollManagerController@update', 'as' => 'poll.update']);
    Route::delete('/admin/polls/{poll}', ['uses' => 'PollManagerController@remove', 'as' => 'poll.remove']);
    Route::patch('/admin/polls/{poll}/lock', ['uses' => 'PollManagerController@lock', 'as' => 'poll.lock']);
    Route::patch('/admin/polls/{poll}/unlock', ['uses' => 'PollManagerController@unlock', 'as' => 'poll.unlock']);
    Route::post('/admin/polls', ['uses' => 'PollManagerController@store', 'as' => 'poll.store']);
    Route::get('/admin/polls/{poll}/options/add', ['uses' => 'OptionManagerController@push', 'as' => 'poll.options.push']);
    Route::post('/admin/polls/{poll}/options/add', ['uses' => 'OptionManagerController@add', 'as' => 'poll.options.add']);
    Route::get('/admin/polls/{poll}/options/remove', ['uses' => 'OptionManagerController@delete', 'as' => 'poll.options.remove']);
    Route::delete('/admin/polls/{poll}/options/remove', ['uses' => 'OptionManagerController@remove', 'as' => 'poll.options.remove']);
    Route::post('/vote/polls/{poll}', ['uses' => 'VoteManagerController@vote', 'as' => 'poll.vote']);
});