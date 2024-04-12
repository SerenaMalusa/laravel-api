<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    // use HasFactory;

    //authorize the automated fill of some fields
    protected $fillable = [
        'name',
        'colour'
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function getColour()
    {
        return '<div style="background-color:' . $this->colour . '; height: 20px; width:100%;"></div>';
    }

    public function getBadge()
    {
        return '<span class="badge" style="background-color:' . $this->colour . ';">' . $this->name . '</span>';
    }
}
