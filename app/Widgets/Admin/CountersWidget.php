<?php

namespace App\Widgets\Admin;

use Theme;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Usecase;
use App\Models\Transaction;
use Arrilot\Widgets\AbstractWidget;
use CyrildeWit\EloquentViewable\Support\Period;

class CountersWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * The number of seconds before each reload.
     *
     * @var int|float
     */
    public $reloadTimeout = 60;

    /**
     * The number of minutes before cache expires.
     * False means no caching at all.
     *
     * @var int|float|bool
     */
    public $cacheTime = 60;

    /**
     * Generate stats for N days
     */
    public $stats_days = 30;

    /**
     * Instance of post Repositories
     *
     * @param  App\Repositories\PostRepository  $postRepository
     */
    protected $postRepository;

    public function __construct(array $config)
    {
        Theme::set('admin');

        parent::__construct($config);
    }

    /**
     * Async widgets placeholder
     */
    public function placeholder()
    {
        return __('widgets.admin.loadingGraphs');
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $range = Carbon::now()->subDays($this->stats_days);
        $agoDate = Carbon::today()->subWeek();

        $toolsCount = Usecase::orderByViews('desc', Period::pastWeeks(1))->count();
        $userCount = User::where('created_at', '>=', $agoDate)->count();
        $transactionCount = Transaction::where('created_at', '>=', $agoDate)->has('plan')->has('user')->sum('amount');
        $postCount = Post::orderByViews('desc', Period::pastWeeks(1))->count();

        //Stats Snippet array
        $counterStats =  array(
            ['class' => 'bg-warning', 'icon' => 'stats-up', 'label' => __("widgets.admin.usecaseCount"),  'value' => $toolsCount],
            ['class' => 'bg-info', 'icon' => 'write',  'label' =>  __("widgets.admin.postsCount"),  'value' => $postCount],
            ['class' => 'bg-danger', 'icon' => 'credit-cards', 'label' =>  __("widgets.admin.payments"),  'value' => money($transactionCount, setting('currency', 'USD'), true)],
            ['class' => 'bg-success', 'icon' => 'users', 'label' =>  __("widgets.admin.newAccounts"),  'value' => $userCount]

        );

        return view('widgets.admin.counters', [
            'config' => $this->config,
            'counterStats' => $counterStats,
        ]);
    }
}
