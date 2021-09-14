<?php

namespace App\Http\View\Composers;

use App\Platform;
use Carbon\Carbon;
use Illuminate\View\View;

class PlatformComposer
{
    /**
     * Create a new Navbar composer.
     *
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $date = Carbon::now();
        $platform = Platform::first();

        $view->with([
            'platform'=> $platform,
            'date'    => $date,
        ]);
    }
}
