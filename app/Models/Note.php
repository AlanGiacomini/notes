<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtFormattedAttribute(){
        return $this->created_at->format('d/m/Y H:i:s');
    }

}
