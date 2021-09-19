<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $mode
     * @return RedirectResponse
     */
    public function darkMode($mode)
    {
        if ($mode == 'on') {
            session(['dark_mode' => 1]);
        } elseif ($mode == 'off') {
            session(['dark_mode' => 0]);
        }
        return redirect()->back();
    }
}
