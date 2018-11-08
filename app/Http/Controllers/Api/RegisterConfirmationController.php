<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class RegisterConfirmationController extends Controller
{

    /**
     * Compares given token and database token if they equal or not.
     *
     * @return mixed
     */
    public function index()
    {
        try {
            $user = User::where('confirmation_token', request('token'))
            ->firstOrFail()
            ->confirm();
        } catch(\Exception $e) {
            return redirect('threads')
                ->with('flash', 'Unknown token');
        }

        return redirect('threads')
            ->with('flash', 'Your acccount is  now confirmed! You may post to the forum');
    }
}
