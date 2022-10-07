<?php

namespace App\Http\Controllers;

use App\Models\Users\User;
use App\Http\Requests\Dashboard\UserRequest;

class DelegateController extends Controller
{
    public function index()
    {
        return view('delegate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $request->merge([
            'type' => User::Delegate,
            'is_active' => false,
        ]);

        $delegate = User::create($request->allWithHashedPassword());

        $delegate->delegate()->updateOrCreate($request->delegate);

        $delegate->addAllMediaFromTokens();

        flash()->success(trans('delegates.messages.registered'));

        return back();
    }
}
