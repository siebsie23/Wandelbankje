<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Bench extends Model
{
    use HasFactory;

    protected $fillable = [
        'latitude',
        'longitude',
    ];

    public function getLikes($id, $like): int
    {
        $likes = DB::table('liked_benches')->where('bench', $id)->where('like', $like);
        return $likes->count();
    }

    public function addLike($id, $like) {
        if(!Auth::check())
            return redirect(route('bench.details', $id))->with('alert', 'Je moet ingelogd zijn om een bankje te beoordelen!');
        $likedbench = LikedBench::where('bench', $id)->where('user', Auth::id());
        if(!$likedbench->exists()) {
            LikedBench::create([
                'user' => Auth::id(),
                'bench' => $id,
                'like' => $like,
            ]);
        }else {
            $likedbench = $likedbench->first();
            if($likedbench->like != $like) {
                $likedbench->like = $like;
                $likedbench->save();
            }
        }
        return redirect(route('bench.details', $id));
    }
}
