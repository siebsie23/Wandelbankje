<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    /**
     *
     * Deze functie accepteert de foto indien deze nieuw is.
     *
     * @param $id
     * @param $approve
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function approveNew($id, $approve) {
        $photo = Photo::find($id);
        if($photo->is_new) {
            if($approve) {
                $photo->is_new = false;
                $photo->save();
            }else {
                $photo->delete();
            }
        }
        return redirect(route('moderator_new_items'));
    }
}
