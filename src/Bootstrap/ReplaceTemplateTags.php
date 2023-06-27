<?php

namespace Expressionengine\Coilpack\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\View;

class ReplaceTemplateTags
{
    /**
     * Bootstrap the given application.
     *
     * @return void
     */
    public function bootstrap(Application $app)
    {
        if (empty(config('coilpack.expressionengine'))) {
            return;
        }

        // Register our Tag replacements
        tap(app(\Expressionengine\Coilpack\View\Exp::class), function ($exp) {
            $exp->registerTag('channel.categories', \Expressionengine\Coilpack\View\Tags\Channel\Categories::class);
            $exp->registerTag('channel.entries', \Expressionengine\Coilpack\View\Tags\Channel\Entries::class);
            $exp->registerTag('comment.entries', \Expressionengine\Coilpack\View\Tags\Comment\Entries::class);
            $exp->registerTag('comment.form', \Expressionengine\Coilpack\View\Tags\Comment\Form::class);
            $exp->registerTag('comment.preview', \Expressionengine\Coilpack\View\Tags\Comment\Preview::class);
            $exp->registerTag('structure.entries', \Expressionengine\Coilpack\View\Tags\Structure\Entries::class);
            $exp->registerTag('structure.nav', \Expressionengine\Coilpack\View\Tags\Structure\Nav::class);
            $exp->registerTag('email.contact_form', \Expressionengine\Coilpack\View\Tags\Email\ContactForm::class);
        });

        View::composer('*', \Expressionengine\Coilpack\View\Composers\GlobalComposer::class);
        View::composer('*', function ($view) {
            $view->with('exp', app(\Expressionengine\Coilpack\View\Exp::class));
        });
    }
}
