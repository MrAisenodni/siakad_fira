<?php

namespace App\Providers;

use App\Models\Settings\{ Menu };
use App\Models\Studies\Article;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\{ Session, View };

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $harticles     = Article::select('id', 'title', 'created_at', 'author', 'category_id')->where('created_at', 'LIKE', '%'.date('Y-m-d', strtotime(now())).'%')->where('disabled', 0)->get();

        View::share('harticles', $harticles);
    }
}
