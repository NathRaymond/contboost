<?php

namespace App\Widgets;

use App\Helpers\Classes\AbstractWidget;
use App\Models\Advertisement as AdvertisementClass;

class Advertisement extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    const TITLE = 'widgets.advertisement.title';
    const DESCRIPTION = 'widgets.advertisement.description';
    const VIEW = 'widgets.advertisement';
    const ADMIN_VIEW = 'widgets.editor.advertisement';

    public function __construct(array $config = array())
    {
        parent::__construct($config);

        $this->set_fields('ajax', false);
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $title = $this->config['title'] ?? false;
        $settings = $this->config['settings'] ?? [];
        $ads = AdvertisementClass::findOrFail($settings->advertisement_id);
        return view(static::VIEW, [
            'title' => $title,
            'settings' => $settings,
            'config' => $this->config,
            'advertisement' => $ads,
        ]);
    }

    public function build($sidebar = false, $widget = [])
    {
        if (!$this->admin_view())
        {
            return;
        }

        $fields = $this->get_fields();
        $title = $this->get_title();
        $description = $this->get_description();
        $advertisements = AdvertisementClass::where('status', 1)->get();

        return view(static::ADMIN_VIEW, compact('advertisements', 'widget', 'sidebar', 'title', 'description', 'fields'));
    }
}
