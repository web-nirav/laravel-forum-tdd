<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;

class ThreadsController extends Controller
{
    public function __construct()
    {
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

        if (request()->wantsJson()) {
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

        if ($channel->exists) {
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
            'title'       => 'required',
            'body'        => 'required',
            'channel_id'  => 'required|exists:channels,id',
        ]);

        $thread = Thread::create([
            'user_id'    => auth()->id(),
            'channel_id' => $request->get('channel_id'),
            'title'      => $request->get('title'),
            'body'       => $request->get('body'),
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);
        
        /* 
        this is the manual way to authorize only user who has created thread can delete it but instead we can leverage the use of laravel policy object to authorize it, we can do this in 3 steps
        1, create policy class, (with passing model so we can get boiler plate code to use.)
        2, then in policy class methods we can apply our logic to check model is same as logged in user,
        3, apply autorize in controller method for perticular action.
        and in blade view file whenever we need to conditional any block of code we can use like @can('update', $thread)
        
        if($thread->user_id != auth()->id())
        {
            if(request()->wantsJson()){
                return response(['status' => 'Permission Denied'], 403);
            }
            
            return redirect()->route('login');
        }
 */
        // $thread->replies()->delete(); // we can override the delete method on model or we can use model events in Thread models boot method
        $thread->delete();
        
        if(request()->wantsJson()){
            return response([], 204);
        }
        
        return redirect()->route('threads.index');
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

    
    
}
