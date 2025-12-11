<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];

    protected $casts = [
        'is_active' => 'bool',
        'order' => 'integer',
    ];

    /**
     * Derive an appropriate icon name based on the service title keywords.
     */
    public function getIconAttribute(): string
    {
        $title = Str::of($this->title ?? '')->lower();

        $keywordIcons = [
            'undername' => 'briefcase',
            'clearence' => 'building-office-2',
            'custom' => 'building-office-2',
            'supplier' => 'users',
            'contract' => 'document-check',
            'door' => 'home-modern',
            'project' => 'rocket-launch',
            'ocean' => 'globe-alt',
            'freight' => 'paper-airplane',
            'dokumen' => 'document-text',
            'legal' => 'scale',
            'lisensi' => 'book-open',
            'konsultasi' => 'user-group',
            'strategi' => 'presentation-chart-line',
            'logistik' => 'truck',
            'pengiriman' => 'arrow-path-rounded-square',
            'keuangan' => 'banknotes',
            'pemasaran' => 'megaphone',
            'produk' => 'cube',
            'riset' => 'magnifying-glass-circle',
            'pelatihan' => 'academic-cap',
            'audit' => 'clipboard-document-check',
        ];

        foreach ($keywordIcons as $keyword => $icon) {
            if ($title->contains($keyword)) {
                return $icon;
            }
        }

        return 'sparkles';
    }
}