<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Laraeast\LaravelSettings\Facades\Settings;

class SettingController extends Controller
{
    /**
     * The list of the files keys.
     *
     * @var array
     */
    protected $files = [
        'logo',
        'favicon',
        'category_slider',
        'slider',
        'offers',
    ];

    /**
     * Display the settings page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return view('dashboard.settings.index');
    }

    /**
     * Update the website global settings.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        foreach (
            $request->except(
                array_merge(['_token', '_method', 'media'], $this->files)
            )
            as $key => $value
        ) {
            Settings::set($key, $value);
            //if ($key == 'delegate_hold_amount')
            //{
            //
            //}
        }

        foreach ($this->files as $file) {
            Settings::set($file)->addAllMediaFromTokens([], $file);
        }

        flash(trans('settings.messages.updated'));

        return back();
    }

    /**
     * Download a fresh database and storage backup.
     *
     * @throws \Illuminate\Validation\ValidationException
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadBackup()
    {
        Artisan::call('backup:run');

        $lastBackup = collect(Storage::disk('local')->files('laravel-backup'))->last();

        if (! $lastBackup) {
            throw ValidationException::withMessages([
                'backup' => trans('backup.not-found'),
            ]);
        }

        return response()
            ->download(
                Storage::disk('local')->path($lastBackup)
            )
            ->deleteFileAfterSend();
    }
}
