<?php

namespace App\Http\Controllers;

use App\User;
use App\Thread;
use App\Channel;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
             ->except([
                'index',
                'show'
             ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Channel  $channel
     * @param  \App\Filters\ThreadFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('thread.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('thread.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'channel_id' => 'required|exists:channels,id',
            'title'      => 'required',
            'body'       => 'required'
        ]);

        $thread = Thread::create([
            'user_id'    => auth()->id(),
            'channel_id' => $request['channel_id'],
            'title'      => $request->title,
            'body'       => request('body')
        ]);

        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $channel_id
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channel_id, Thread $thread)
    {
        return view('thread.show', [
            'thread'    => $thread,
            'replies'   => $thread->replies()->paginate(4)
        ]);

        // NOTE: Eager load can save us from N+1 problem
        // return $thread->load(['replies.favorites', 'replies.owner']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        // NOTE: A manual version of Policy
        // if ($thread->user_id != auth()->id()) {
        //     if (request()->wantsJson()) {
        //         return response(['status' => 'Permission Denied'], 403);
        //     }

        //     abort(403, 'You do not have permission to delete other user thread');
            
        //     // return redirect('/login');
        // }

        $thread->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/thread');
    }

    /**
     * A helper to format a thread data retreived from DB
     *
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return Thread
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        // NOTE: Show actual queries running
        // dd($threads->toSql());

        return $threads->get();
    }
}
