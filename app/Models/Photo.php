<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

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
