<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WatchList extends Model
{
    protected $table = 'watch_list';

    protected $guarded = [
        'id'
    ];

    public $timestamps = false;

    public function pair()
    {
        return $this->hasOne(Pair::class);
    }
}
