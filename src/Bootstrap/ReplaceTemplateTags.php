<?php

namespace Expressionengine\Coilpack\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\View;

class ReplaceTemplateTags
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        if (empty(config('coilpack.expressionengine'))) {
            return;
        }

        // Register our Tag replacements
        tap(app(\Expressionengine\Coilpack\View\Exp::class), function ($exp) {
            $exp->registerTag('channel.entries', new \Expressionengine\Coilpack\View\Tags\Channel\Entries);
            $exp->registerTag('comment.entries', new \Expressionengine\Coilpack\View\Tags\Comment\Entries);
            $exp->registerTag('structure.entries', new \Expressionengine\Coilpack\View\Tags\Structure\Entries);
            $exp->registerTag('email.contact_form', new \Expressionengine\Coilpack\View\Tags\Email\ContactForm);
        });

        View::composer('*', \Expressionengine\Coilpack\View\Composers\GlobalComposer::class);
        View::composer('*', function ($view) {
            $view->with('exp', app(\Expressionengine\Coilpack\View\Exp::class));
        });
    }
}
