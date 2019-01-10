<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Favorite;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }
    public function store(Reply $reply)
    {
        $reply->favorite();
        return back();
        // $reply->favorites()->create(['user_id' => auth()->id]);
        /* Favorite::create([
            'user_id' => auth()->id,
            'favorited_id' => $reply->id,
            'favorited_type' => get_class($reply)
        ]); */
        
    }
}
