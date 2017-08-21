<?php

namespace Cbwar\Laravel\BoilerplateChangesTracking\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder as Builder;

class Tracks
{
    public function make(Builder $menu)
    {
        $menu->add(__('boilerplate_tracks::admin.main_title'), ['route' => 'tracks.index', 'permission' => 'changestracking_view', 'icon' => 'database'])
            ->id('tracks')
            ->order(1900)
            ->activeIfRoute('tracks.*');


    }
}