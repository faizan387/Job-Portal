<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'roles',
        'job_type',
        'address',
        'salary',
        'application_close',
        'feature_image',
        'slug',
    ];

    public function users()
    {
        // with pivot is used to retrieve the column calues when querying the middle table
        return $this->belongsToMany(User::class, 'user_listing', 'listing_id', 'user_id')
            ->withPivot('shortlisted')
            ->withTimestamps();
    }

    public function profile()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
