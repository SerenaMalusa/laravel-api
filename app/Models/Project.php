<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'repository',
        'github_link',
        'creation_date',
        'last_commit',
        'type_id'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }

    public function getTechnologiesBadges()
    {
        //create an empty string
        $html_tags = '';

        //for each technolgy related to the single project
        foreach ($this->technologies as $technology) {
            //add to the html_tags string a span with bg color = the tech's colour and content = the tech's name
            $html_tags = $html_tags . '<span class="badge ms-2" style="background-color:' . $technology->colour . ';">' . $technology->name . '</span>';
        }

        //return the completed string
        return $html_tags;
    }
}
