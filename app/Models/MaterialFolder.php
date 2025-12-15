<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialFolder extends Model
{
    use HasFactory, Uuids;

    protected $table = 'material_folders';

    protected $fillable = [
        'batch_id',
        'title',
        'description',
        'order_number',
        'tutor_id',
        'is_published',
        'meeting_number',
        'meeting_title',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'order_number' => 'integer',
    ];

    /**
     * Get the batch that owns the MaterialFolder
     */
    public function batch()
    {
        return $this->belongsTo(PaketUjian::class, 'batch_id');
    }

    /**
     * Get the tutor that owns the MaterialFolder
     */
    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    /**
     * Get the materials for the folder
     */
    public function materials()
    {
        return $this->hasMany(Material::class, 'folder_id')->with('tutor');
    }

    /**
     * Scope a query to only include published folders
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to order by meeting number
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('meeting_number')->orderBy('order_number');
    }

    /**
     * Get formatted meeting title
     */
    public function getFormattedTitleAttribute()
    {
        if ($this->meeting_number && $this->meeting_title) {
            return "Pertemuan {$this->meeting_number}: {$this->meeting_title}";
        }
        
        if ($this->meeting_number) {
            return "Pertemuan {$this->meeting_number}";
        }
        
        return $this->title;
    }

    /**
     * Get materials count by type
     */
    public function getMaterialsCountByType()
    {
        return $this->materials()
            ->selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();
    }

    /**
     * Get total materials count
     */
    public function getTotalMaterialsCountAttribute()
    {
        return $this->materials()->count();
    }
}