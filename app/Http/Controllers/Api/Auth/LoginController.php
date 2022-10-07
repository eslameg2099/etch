<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Users\UpdateMobileNumber;
use App\Http\Resources\UserResource;
use App\Interfaces\UsersRepositoryInterface;
use App\Models\MasterData\SmsLog;
use App\Models\Users\User;
use App\Traits\HISMS;
use App\Traits\RepositoryResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Pusher\Pusher;
use Pusher\PushNotifications\PushNotifications;

class LoginController extends Controller
{
    use RepositoryResponseTrait, HISMS;

    private $userRepo;

    public function __construct(UsersRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
        $this->middleware('guest')->except(
            'resendSmsVerificationCode',
            'checkPhoneIsExists',
            'logout',
            'changePassword',
            'verifyMobileNumber',
            'profile',
            'changeMobileNumber',
            'getPusherNotificationToken',
            'getPusherChannelToken'
        );
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        return $this->attemptLogin($request);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'device_name' => 'required',
        ]);
    }

    public function username()
    {
        return 'mobile';
    }

    protected function attemptLogin(Request $request)
    {
        $user = User::query()->where('mobile', $request->mobile)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.failed')],
            ]);
        }

        return response()->json([
            'user' => new UserResource($user),
            'token' => $user->createToken($request->device_name)->plainTextToken,
        ]);
    }

    public function verifyMobileNumber(Request $request)
    {
        $sms = $request->user()->lastVerificationCode();

        if (is_null($sms) || $sms->code != $request->input('code')) {
            return $this->error(['message' => trans('errors.invalid_verification_code'),]);
        }
        $request->user()->forceFill(['mobile_verified_at' => Carbon::now()])->save();
        $request->user()
            ->sms()
            ->where('type', SmsLog::VerifyCode)
            ->whereNotNull('code')
            ->update(['code' => null]);

        return $this->success([
            'message' => trans('global.confirmed_success'),
            'user' => new UserResource($request->user()),
        ]);
    }

    public function resendSmsVerificationCode()
    {
        return $this->resendVerificationCode(\request());
    }

    public function checkPhoneIsExists(Request $request)
    {
        $user = User::query()
            ->where('mobile', $request->input('mobile'))
            ->first();
        if (! $user && auth()->check() && $request->input('change_number') == 1) {
            $this->sendVerificationCode(auth()->user(), 'global.change_mobile_code', SmsLog::ChangePhoneNumber,
                $request->input('mobile'));
        }

        return response()->json(['status' => true, 'exists' => (boolean)$user]);
    }

    public function changeMobileNumber(UpdateMobileNumber $request)
    {
        $sms = $request->user()->lastChangePhoneNumberCode();
        if (! Hash::check(request('password'), $request->user()->password)) {
            return $this->validationError(['message' => trans('errors.password_not_correct')]);
        }
        if (! $sms || $sms->code != $request->code) {
            return $this->validationError(['message' => trans('errors.invalid_code')]);
        }

        $request->user()->update(['mobile' => $request->mobile, 'mobile_verified_at' => Carbon::now()]);

        $request->user()->sms()
            ->where('type', SmsLog::ChangePhoneNumber)
            ->whereNotNull('code')
            ->update(['code' => null]);

        return $this->success([
            'message' => trans('global.mobile_updated'),
            'user' => new UserResource($request->user()->refresh()),
        ]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        return $this->userRepo->changePassword();
    }

    public function sendResetPasswordCode()
    {
        $user = $this->userRepo->getUserByMobile();

        return $this->sendResetPasswordVerificationCode($user);
    }

    public function checkResetPasswordCode(Request $request)
    {
        $user = User::query()->firstWhere('mobile', $request->mobile);
        if (! $user) {
            return $this->error(['message' => trans('errors.user_not_found')]);
        }
        $sms = $user->lastResetPasswordCode();

        return isset($sms) && $sms->code == $request->code ?
            $this->success(['status' => 1]) :
            $this->error(['status' => 0]);
    }

    public function resetPassword()
    {
        return $this->userRepo->resetMyPassword();
    }

    public function profile()
    {
        return $this->success([
            'user' => new UserResource(\request()->user()),
        ]);
    }

    public function getPusherNotificationToken(Request $request)
    {
        $config = config('services.pusher');

        $beamsClient = new PushNotifications([
            'instanceId' => $config['beams_instance_id'],
            'secretKey' => $config['beams_secret_key'],
        ]);

        $token = $beamsClient->generateToken((string)auth()->id());

        return response()->json($token);
    }

    public function logout()
    {
        $user = \request()->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return $this->success(['message' => trans('global.operation_succeeded')]);
    }
}
