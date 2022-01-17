<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * base table
     * @var string
     */
    protected $table = 'movies';

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
        'name',
        'published_at',
        'thumbnail',
        'status'
    ];

    /**
     * Movie Turns
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function turns() {
        return $this->belongsToMany(Turn::class, 'movie_turn', 'turn_id', 'movie_id');
    }
}
