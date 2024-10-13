<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\OTC;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function Login(LoginRequest $request)
    {
        // dd($request->all());
        $request->validated();

        $user = User::query()->firstWhere([
            'phone_number' => $request->phone_number,
            'email' => $request->email,
        ]);

        if (!$user) {
            return response(
                [
                    'error' => true,
                    'message' => 'User not found'
                ],
                404,
                ['content-type' => 'application/json']
            );
        }
        $pin = random_int(100000, 999999);
        $otc = OTC::all(['code']);
        if ($otc !== null) {
            if (in_array($pin, $otc->toArray())) {
                $pin = random_int(100009, 199999);
            }
        }
        $saved_otc =  OTC::updateOrCreate([
            'user_id' => $user->id
        ], [
            'user_id' => $user->id,
            'code' => $pin,
            'expired_at' => Carbon::now()->addMinutes(5)
        ]);

        // Send OTC via SMS
        // SMS::send($user->phone_number, "Your OTC code is: $otc.\nDo not share your OTC with others");
        try {
            // Code... to continue
            // Resend OTC via SMS to the user's phone number
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response(['error' => true, 'message' => $e->getMessage()], 500);
        }
        return response([
            'sucess' => true,
            'data' => [
                'otc' => $saved_otc->code,
                'access_token' => null,
                'is_authenticated' => false,
                'otc_sent' => true,
                'user' => new UserResource($user),
            ],
        ], 200);
    }

    public function  validateOTC(Request $request)
    {
        $request->validate([
            'otc' => 'required|exists:login_otc,code',
            'user_id' => 'required|exists:users,id',
            'device' => 'nullable|string',
        ]);

        $otc = OTC::with('user')->firstWhere(['user_id' => $request->user_id, 'code' => $request->otc]);

        if (!$otc) {
            return response(['error' => true, 'message' => 'Invalid OTC'], 422);
        }

        $user_id = $otc->user->id;
        $user = User::query()->find($user_id);
        $token = $user->createToken($request->device ?? 'access_token', ['*'])->plainTextToken;

        Auth::login($user, true);

        return response([
            'success' => true,
            'data' => [
                'access_token' => $token,
                'is_authenticated' => true,
                'user_device' => $request->device ?? null,
                'user' => $user,
            ],
        ], 202);
    }
    public function resendOTC(LoginRequest $request)
    {
        // $user = $request->user();
        $request->validated();

        $otc = random_int(100000, 999999);
        $saved_otc = OTC::all(['code']);

        if (in_array($otc, $saved_otc->toArray())) {
            $otc = random_int(100009, 199999);
        }
        $user = User::query()->firstWhere([
            'phone_number' => $request->phone_number,
            'email' => $request->email,
        ]);
        $pin = OTC::where('user_id', $user->id)->update(
            [
                'user_id' => $user->id,
                'code' => $otc
            ]
        );
        try {
            // Code... to continue
            // Resend OTC via SMS to the user's phone number
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response(['error' => true, 'message' => $e->getMessage()], 500);
        }
        return response([
            'success' => true,
            'data' => [
                'user' => $user,
                'otc' => $pin->code,
                'access_token' => null,
                'is_authenticated' => false,
            ],
        ], 200);
        // return response(['success' => true, 'user' => $user, 'otc' => $pin->code], 201);
    }
}
