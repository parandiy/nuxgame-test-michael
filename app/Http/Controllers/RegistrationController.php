<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class RegistrationController
 */
class RegistrationController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('registration.index');
    }

    /**
     * @param  RegistrationRequest  $request
     * @param  UserService  $userService
     * @return RedirectResponse
     */
    public function store(RegistrationRequest $request, UserService $userService): RedirectResponse
    {
        $user = $userService->createUserWithAccess($request->post('name'), $request->post('phone'));

        return redirect()->back()->with('link', route('dashboard.index', ['hash' => $user->getValidAccessHash()]));
    }
}
