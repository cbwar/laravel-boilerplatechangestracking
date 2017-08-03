<?php

namespace Cbwar\Laravel\BoilerplateTracks\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder as Builder;

class Tracks
{
    public function make(Builder $menu)
    {
        $menu->add(__('boilerplate_tracks::admin.menu.main_title'), ['permission' => 'tracks_crud', 'icon' => 'tracks'])
            ->id('tracks')
            ->order(1200);

        $menu->addTo('tracks', __('boilerplate_tracks::admin.menu.show'), ['route' => 'tracks.index', 'permission' => 'tracks_crud'])
            ->order(1210)
            ->activeIfRoute('tracks.*');

    }
}