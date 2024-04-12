<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    // use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'colour'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function getBadge()
    {
        return '<span class="badge" style="background-color:' . $this->colour . ';">' . $this->name . '</span>';
    }

    public function getColour()
    {
        return '<div style="background-color:' . $this->colour . '; height: 20px; width:100%;"></div>';
    }
}
