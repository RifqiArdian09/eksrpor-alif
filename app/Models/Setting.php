<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
    ];

    protected $attributes = [
        'type' => 'text',
    ];

    public function getValueAttribute($value): mixed
    {
        return $this->type === 'json' ? json_decode($value, true) : $value;
    }

    public function setValueAttribute($value): void
    {
        if (is_array($value)) {
            $this->attributes['type'] = 'json';
            $this->attributes['value'] = json_encode($value);

            return;
        }

        $this->attributes['value'] = $value;
    }
}