<?php

namespace App\Listeners;

use App\Events\ViewCount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Session;
use Illuminate\Http\Request;
use App\Models\View;
use App\Models\Truyen;
use DB;
use Carbon\Carbon;

class ViewFollow
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  ViewCount  $event
     * @return void
     */
    public function handle(ViewCount $event)
    {
        $truyen = $event->truyen;
        if (!$this->checkSessionViews($truyen)) {
            $truyen->view_count+=1;
            $truyen->save();
            $views = new View;
            $views->id_truyen=$truyen->id;
            $views->save();
            $this->sessionPutViews($truyen);
        }
    }
    private function checkSessionViews($truyen)
    {
        return array_key_exists($truyen->id, Session::get('views',[]));
    }
    private function sessionPutViews($truyen)
    {
        return Session::put('views.'.$truyen->id,Carbon::now());
    }
}
