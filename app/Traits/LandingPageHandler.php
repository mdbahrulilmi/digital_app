<?php

namespace App\Traits;

use App\Models\LandingPageComponent;

trait LandingPageHandler
{
    protected function updateLandingPageComponents($types, $mapping, $editingId, $newData)
    {
        $components = LandingPageComponent::whereIn('type', $types)->get();

        foreach ($components as $component) {
            $content = $component->content;
            $updated = false;

            foreach ($mapping as $map) {
                if (($content[$map['id_key']] ?? null) == $editingId) {
                    $content[$map['title_key']] = $newData['title'];
                    $content[$map['slug_key']]  = $newData['slug'];
                    $content[$map['desc_key']]  = $newData['description'];
                    $content[$map['price_key']] = $newData['price'];
                    $content[$map['image_key']] = $newData['image'];

                    if (isset($map['start_date_key'])) {
                        $content[$map['start_date_key']] = $newData['start_date'];
                    }
                    if (isset($map['end_date_key'])) {
                        $content[$map['end_date_key']] = $newData['end_date'];
                    }
                    
                    $updated = true;
                }
            }

            if ($updated) {
                $component->update(['content' => $content]);
            }
        }
    }
}