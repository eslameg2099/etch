<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactUs = ContactUs::filter()->paginate();

        return view('dashboard.contact_us.index', compact('contactUs'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $message
     * @return \Illuminate\Http\Response
     */
    public function show($message)
    {
        $message = ContactUs::findOrFail($message);

        return view('dashboard.contact_us.show', compact('message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $message
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($message)
    {
        $message = ContactUs::findOrFail($message);

        $message->delete();

        flash()->success(trans('contact_us.messages.deleted'));

        return redirect()->route('dashboard.contact_us.index');
    }
}
