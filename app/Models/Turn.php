<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
    use HasFactory;

    /**
     * base table
     * @var string
     */
    protected $table = 'turns';

    /**
     * Primary key for the table
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Updatable columns
     * @var string[]
     */
    protected $fillable = [
        'time',
        'status',
    ];

    /**
     * Movie Turns
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function movies() {
        return $this->belongsToMany(Movie::class, 'movie_turn', 'movie_id', 'turn_id');
    }

}
