<?php

namespace App\Extensions;

use Spatie\Sluggable\HasSlug as BaseHasSlug;

trait HasSlug
{
    use BaseHasSlug;

    protected function makeSlugUnique(string $slug): string
    {
        $originalSlug = $slug;
        $i = 1;

        while ($this->otherRecordExistsWithSlug($slug) || $slug === 'feed') {
            $slug = $originalSlug.$this->slugOptions->slugSeparator.$i++;
        }

        return $slug;
    }
}
