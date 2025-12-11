<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Highlight extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * Determine default icon based on highlight title keywords.
     */
    public function getIconAttribute(): string
    {
        $title = Str::of($this->title ?? '')->lower();

        $keywordIcons = [
            'hemat' => 'wallet',
            'biaya' => 'currency-dollar',
            'dokumen' => 'document-check',
            'legal' => 'scale',
            'lisensi' => 'receipt-percent',
            'konsultasi' => 'user-group',
            'strategi' => 'presentation-chart-line',
            'logistik' => 'truck',
            'pengiriman' => 'paper-airplane',
            'keuangan' => 'banknotes',
            'pemasaran' => 'megaphone',
            'produk' => 'cube',
            'riset' => 'magnifying-glass-circle',
            'pelatihan' => 'academic-cap',
            'jaringan' => 'globe-alt',
            'aman' => 'shield-check',
            'layanan' => 'sparkles',
        ];

        foreach ($keywordIcons as $keyword => $icon) {
            if ($title->contains($keyword)) {
                return $icon;
            }
        }

        return 'check-circle';
    }
}