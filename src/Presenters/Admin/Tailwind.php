<?php

namespace Akaunting\Menu\Presenters\Admin;

use Akaunting\Menu\Presenters\Presenter;
use Illuminate\Support\Str;

class Tailwind extends Presenter
{
    /**
     * {@inheritdoc }.
     */
    public function getOpenTagWrapper()
    {
        return PHP_EOL . '<div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="flex flex-col justify-center">' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getCloseTagWrapper()
    {
        return PHP_EOL . '</ul>
            </div>
        </div>' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getMenuWithoutDropdownWrapper($item)
    {
        return '<li class="group relative mb-2.5">
                    <a class="flex items-center text-secondary" href="' . $item->getUrl() . '" ' . $item->getAttributes() . '>
                        <div class="w-8 h-8 flex items-center justify-center">
                        ' . $this->getIcon($item) . '
                        </div>
                        <span class="text-sm ml-2 hover:font-bold">' . $item->title . '</span>
                        <span class="bg-secondary absolute h-5 -right-5 rounded-tl-lg rounded-bl-lg opacity-0 group-hover:opacity-100 transition-all" style="width: 5px;" ></span>
                    </a>
                </li>'
                . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getActiveState($item, $state = '' )
    {
        return $item->isActive() ? $state : '-outline';
    }

    /**
     * Get active state on child items.
     *
     * @param $item
     * @param string $state
     *
     * @return null|string
     */
    public function getActiveStateOnChild($item, $state = 'open')
    {
        return $item->hasActiveOnChild() ? $state : '';
    }

    /**
     * Get active state on child items.
     *
     * @param $item
     * @param string $state
     *
     * @return null|string
     */
    public function getShowStateOnChild($item, $state = 'open')
    {
        return $item->hasActiveOnChild() ? $state : ' ';
    }

    /**
     * {@inheritdoc }.
     */
    public function getDividerWrapper()
    {
        return '<hr class="my-3">';
    }

    /**
     * {@inheritdoc }.
     */
    public function getHeaderWrapper($item)
    {
        return '<h6 class="navbar-heading p-0 text-muted">' . $item->title . '</h6>';
    }

    /**
     * {@inheritdoc }.
     */
    public function getMenuWithDropDownWrapper($item)
    {
        $id = Str::slug($item->title);

        return '
        <details '. $this->getActiveStateOnChild($item) .'>
            <summary class="relative mb-2.5 flex mt-2 items-center cursor-pointer text-secondary" href="#navbar-' . $id . '">
                ' . $this->getIcon($item) . '
                <span class="text-sm font-normal ml-2">' . $item->title . '</span>
                ' . $this->getChevron($item) . '
            </summary>
            <div class="mt-2 ml-8 " id="navbar-' . $id . '">
                <ul class="relative pb-2.5">
                    ' . $this->getChildMenuItems($item) . '
                </ul>
            </div>
        </details>'
        . PHP_EOL;
    }

    /**
     * Get multilevel menu wrapper.
     *
     * @param \Akaunting\Menu\MenuItem $item
     *
     * @return string`
     */
    public function getMultiLevelDropdownWrapper($item)
    {
        $id = Str::slug($item->title);

        return '<li class="nav-item">
    <a class="nav-link' . $this->getActiveState($item) . '" href="#navbar-' . $id . '" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-' . $id . '">
        ' . $item->getIcon() . '
        <span class="nav-link-text">' . $item->title . '</span>
    </a>
    <div class="collapse' . $this->getShowStateOnChild($item) . '" id="navbar-' . $id . '">
        <ul class="nav nav-sm flex-column">
            ' . $this->getChildMenuItems($item) . '
        </ul>
    </div>
</li>'
        . PHP_EOL;
    }

    public function getIcon($item)
    {
        $state = $this->iconState($item);

        return '<div class="w-8 h-8 flex colour-secondary items-center justify-center">
                    <ion-icon class="w-5 h-5 text-secondary colour-secondary ' . $item->icon . '" name="' . $item->icon . $state .'"></ion-icon>
                </div>'. PHP_EOL;
    }

    public function getChevron($item)
    {
        $state = $this->chevronState($item);

        return '<ion-icon data-id="cash" name="chevron' . $state . '" class="absolute right-0"></ion-icon>'. PHP_EOL;
    }

    public function iconState($item, $state = '')
    {
        return $item->hasActiveOnChild() ? $state : '-outline';
    }

    public function chevronState($item, $state = '-up')
    {
        return $item->hasActiveOnChild() ? $state : '-down';
    }
}
