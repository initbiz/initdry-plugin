<?php

declare(strict_types=1);

namespace Initbiz\InitDry\Tests\Classes;

use October\Rain\Mail\Mailable;
use October\Rain\Mail\FakeMailer as MailFakeBase;

/**
 * In your tests you can use following code with this FakeMailer:
 *
 * $actualMailManager = Mail::getFacadeRoot();
 * Mail::swap(new FakeMailer($actualMailManager));
 */
class FakeMailer extends MailFakeBase
{
    /**
     * send a new message using a view
     */
    public function sendTo($to, $view, $data = [], $callback = null): void
    {
        if (!$view instanceof Mailable) {
            $view = $this->buildMailable($view, $data, $callback);
        }

        $view->to($to);

        parent::send($view, $data = [], $callback = null);
    }

    /**
     * Get all of the mailed mailables for a given type.
     *
     * @param  string  $type
     * @return \Illuminate\Support\Collection
     */
    public function getMailablesOf($type)
    {
        return $this->mailablesOf($type);
    }
}
