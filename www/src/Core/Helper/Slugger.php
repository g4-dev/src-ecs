<?php
namespace Core\Helper;

use Core\Entity\Model\Sluggable;

class Slugger
{

    /**
     *
     * Create slug for an entity
     *
     * @param Sluggable $entity
     * @return string
     */
    public static function slugify(Sluggable $entity): string
    {
        $name = $entity->getName();
        $slug = str_replace(' ', '-', $name);
        $transliterator = \Transliterator::createFromRules(':: NFD; :: [:Nonspacing Mark:] Remove; :: Lower(); :: NFC;', \Transliterator::FORWARD);
        $slug = $transliterator->transliterate($slug);
        $slug = preg_replace('/[^a-z0-9\-]/i', '', $slug);
        $slug = preg_replace('/\s+/', '', $slug);

        return $slug;
    }
}
