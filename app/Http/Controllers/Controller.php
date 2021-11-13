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
    public function darkMode()
    {
        session(['dark_mode' => !session('dark_mode')]);
        return redirect()->back();
    }

    public function toggleSidebar()
    {
        session(['sidebar' => !session('sidebar')]);
        return response()->json(['success' => true, 'sidebar' => session('sidebar')]);
    }
}
