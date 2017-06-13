<?php
namespace App\Traits;

trait HasTranslatedAttributes
{
    public function getTranslatedAttributesAttribute()
    {
        return $this->translatedAttributes;
    }
}