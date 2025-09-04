<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TahvelCookieController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $response = Http::withHeaders([
            'cookie' => $request->tahvel_cookie,
        ])->get('https://tahvel.edu.ee/hois_back/user');

        if (!$response->ok() || empty($response->body())) {
            abort(442);
        }

        $request->user()->update([
            'tahvel_cookie' => $request->tahvel_cookie,
        ]);

        return redirect()->to(route('dashboard'));
    }
}