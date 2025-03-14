<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $fillable = [
        'program_name_th','program_name_en'
    ];
    public function users()
    {
        return $this->hasMany(User::class);
        
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public static function getProgramCode($name)
    {
        $map = [
            'Computer Science' => 'CS',
            'Information Technology' => 'IT',
            'Geo-Informatics' => 'GIS',
        ];

        return $map[$name] ?? $name;
    }
}
