<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    
    /**
     * Método busca notas sabendo que a relação Users/Notes é de 1 para muitos
     */
    public function notes(){
        return $this->hasMany(Note::class);
    }
}
