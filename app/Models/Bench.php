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
        'added_by',
        'is_new',
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

    public function approveNew($id, $approve) {
        $bench = Bench::find($id);
        if($bench->is_new) {
            if($approve) {
                $bench->is_new = false;
                $bench->save();
            }else {
                $bench->delete();
            }
        }
        return redirect(route('moderator_new_items'));
    }

    public function reset($id, $report_id, $reset) {
        $alert = 'Aantal keer gerapporteerd gereset!';
        $report = ReportedBench::find($report_id);
        $report->delete();
        if(!$reset) {
            $bench = Bench::find($id);
            $bench->delete();
            $alert = 'Bankje succesvol verwijderd!';
        }
        return redirect(route('moderator_reported_items'))->with('alert', $alert);
    }
}
