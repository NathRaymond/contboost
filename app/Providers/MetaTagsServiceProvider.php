<?php

namespace App\Providers;

use Setting;
use Illuminate\Support\Str;
use Butschster\Head\MetaTags\Meta;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Butschster\Head\Facades\Meta as MetaTag;
use Butschster\Head\MetaTags\Entities\Webmaster;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\MetaTags\Entities\GoogleAnalytics;
use Butschster\Head\Packages\Entities\OpenGraphPackage;
use Butschster\Head\Contracts\Packages\ManagerInterface;
use Butschster\Head\Packages\Entities\TwitterCardPackage;
use Butschster\Head\Providers\MetaTagsApplicationServiceProvider as ServiceProvider;

class MetaTagsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        if (!Config::get('artisan.installed')) {
            return;
        }
        $this->initMacros();
        $this->setDefaults();
    }

    protected function packages()
    {
        // Create your own packages here
    }

    // if you don't want to change anything in this method just remove it
    protected function registerMeta(): void
    {
        $this->app->singleton(MetaInterface::class, function () {
            $meta = new Meta(
                $this->app[ManagerInterface::class],
                $this->app['config']
            );

            // add favicon if it exists
            if (setting('favicon')) {
                $meta->setFavicon(url(setting('favicon')));
            }

            if (setting('google_webmaster') != '') {
                $meta->addWebmaster(Webmaster::GOOGLE, setting('google_webmaster'));
            }
            if (setting('yandex_webmaster') != '') {
                $meta->addWebmaster(Webmaster::YANDEX, setting('yandex_webmaster'));
            }
            if (setting('bing_webmaster') != '') {
                $meta->addWebmaster(Webmaster::BING, setting('bing_webmaster'));
            }
            if (setting('pinterest_webmaster') != '') {
                $meta->addWebmaster(Webmaster::PINTEREST, setting('pinterest_webmaster'));
            }
            if (setting('alexa_webmaster') != '') {
                $meta->addWebmaster(Webmaster::ALEXA, setting('alexa_webmaster'));
            }
            if (setting('facebook_webmaster') != '') {
                $meta->addWebmaster(Webmaster::FACEBOOK, setting('facebook_webmaster'));
            }

            $meta->initialize();

            return $meta;
        });
    }

    protected function initMacros()
    {
        $this->initMeta();
        $this->initFortMacro();
    }

    protected function setDefaults()
    {
        if (!Config::get('artisan.installed')) {
            return;
        }

        \Butschster\Head\Facades\Meta::setFont([]);
        $this->googleAnalytics();
        $this->registerMeta();
        $this->generatorMeta();
        $this->dynamicCss();
    }

    protected function dynamicCss()
    {
        $themeName = config('artisan.front_theme');
        $path = "css/{$themeName}-css.css";
        $css_file_name = "{$themeName}-css.css";

        if (Storage::disk('public')->exists($path) && $themeName == Config::get('artisan.front_theme')) {
            $dynamic_css_url = Storage::disk('public')->url($path);

            MetaTag::addStyle($css_file_name, $dynamic_css_url);
        }
    }

    protected function generatorMeta()
    {
        MetaTag::addMeta('generator', [
            'content' => __('AIRobo v:version', ['version' => Setting::get('version', '1.0.0')])
        ]);
    }

    protected function googleAnalytics()
    {
        if (setting('google_analytics_id', false)) {
            $analytics = new GoogleAnalytics(setting('google_analytics_id'));
            MetaTag::addTag('google.analytics', $analytics, 'head');
        }
    }

    /**
     * Set defautl metas
     */
    public function initMeta()
    {
        Meta::macro(
            'setMeta',
            function ($meta = null) {
                $app_name = Config::get('app.name');
                $title = $meta->title ?? $meta->meta_title ?? Setting::get('meta_title');
                $description = $meta->meta_description ?? $meta->description ?? Setting::get('meta_description');

                $og_title = $meta->og_title ?? $title;
                $og_description = $meta->og_description ?? $description;
                $og_image = null;
                if ($meta && method_exists($meta, 'getFirstMediaUrl')) {
                    $og_image = $meta->getFirstMediaUrl('og-image');
                }

                $site_twiitter = Str::start(Setting::get('twitter_username', 'dotartisan'), '@');
                $url = $meta->url ?? \Request::fullUrl();

                //canonical
                if (!empty($url)) {
                    $this->setCanonical($url);
                }

                //escape title and description
                $escOGTitle = e(strip_tags($og_title));
                $escOGDescription = e(strip_tags($og_description));

                //facebook OG
                $og = new OpenGraphPackage('pageOg');
                $og->setType('website')
                    ->setSiteName($app_name)
                    ->setTitle($escOGTitle)
                    ->setDescription($escOGDescription)
                    ->setUrl($url);

                if (!empty($og_image)) {
                    $og->addImage($og_image);
                }

                //twitter card
                $card = new TwitterCardPackage('pageTwitter');
                $card->setType('summary')
                    ->setSite($site_twiitter)
                    ->setTitle($escOGTitle)
                    ->setDescription($escOGDescription);
                if (!empty($site_twiitter)) {
                    $card->setCreator($site_twiitter);
                }
                if (!empty($og_image)) {
                    $card->setImage($og_image);
                }

                if (setting('append_sitename', 1) == 1) {
                    $this->prependTitle($title);
                } else {
                    $this->setTitle($title);
                }

                $this->setDescription($description)
                    ->registerPackage($card);
                $this->registerPackage($og);
                $this->registerPackage($card);
            }
        );
    }

    protected function initFortMacro()
    {
        Meta::macro(
            'setFont',
            function ($font) {
                $body_font = $font['body_family'] ?? 'Inter';
                $body_variant = $font['body_variant'] ?? 'regular,300,600,700';
                $heading_font = $font['heading_font'] ?? 'Inter';
                $heading_variant = $font['heading_variant'] ?? 'regular,700';

                if ($body_font == $heading_font) {
                    $font_varient = implode(",", array_unique(array_merge(explode(",", $body_variant), explode(",", $heading_variant))));

                    $font = 'https://fonts.googleapis.com/css?family=' . $body_font . ':' . $font_varient . '&display=swap';
                } else {
                    $font = 'https://fonts.googleapis.com/css?family=' . $body_font . ':' . $body_variant . '|' . $heading_font . ':' . $heading_variant . '&display=swap';
                }

                $this->addLink('stylesheet', ['href' => $font]);
            }
        );
    }
}
