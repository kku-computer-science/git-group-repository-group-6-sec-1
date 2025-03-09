<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;

    protected $hidden = [
        'pivot'
    ];

    protected $fillable = [
        'paper_name',
        'paper_type',
        'paper_sourcetitle',
        'paper_url',
        'paper_yearpub',
        'paper_volume',
        'paper_issue',
        'paper_citation',
        'paper_page',
        'paper_doi',
        'keywords'
    ];

    protected $casts = [
        'keywords' => 'array',
    ];
    
    public function teacher()
    {
        return $this->belongsToMany(User::class, 'teacher_papers');
    }

    public function sources()
    {
        return $this->belongsToMany(Source_data::class, 'source_papers');
    }

    public function author()
    {
        return $this->belongsToMany(Author::class, 'author_of_papers');
    }
}