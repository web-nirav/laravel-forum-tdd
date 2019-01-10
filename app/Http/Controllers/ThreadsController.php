<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;

class ThreadsController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = $this->getThreds($channel, $filters);

        if(request()->wantsJson()){
            return $threads;
        }

        /* if($channel->exists)
            $threads = $channel->threads()->latest();
        else
            $threads = Thread::latest(); */

        // if request('by'), we should filter by given username.
        /* if($username = request('by')){
            $user = \App\User::whereName($username)->firstOrFail();
            
            $threads->where('user_id', $user->id);
        } */
        // $threads = Thread::filter($filters)->get();

        return view('threads.index', compact('threads'));
    }

    protected function getThreds($channel, $filters)
    {
        $threads = Thread::latest()->filter($filters); // removed with('channel') as added in Thred model to eager load for all queries

        if($channel->exists){
            $threads->where('channel_id', $channel->id);
        }

        // dd($threads->toSql());

        return $threads->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
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
           'title'  => 'required',
           'body'  => 'required',
           'channel_id'  => 'required|exists:channels,id',
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => $request->get('channel_id'),
            'title' => $request->get('title'),
            'body' => $request->get('body'),
        ]);

        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId, Thread $thread)
    {
        // return $thread->replies;
        // return $channelId;
        // $thread here we should eager load owner or user
        $replies = $thread->replies()->paginate(10);
        return view('threads.show', compact(['thread', 'channelId', 'replies']));
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
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
}
