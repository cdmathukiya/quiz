<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeLevelFormRequest;
use App\Http\Requests\CloseAccountFormRequest;
use App\Http\Requests\ConfirmUpdateEmailRequest;
use App\Http\Requests\UpdateEmailFormRequest;
use App\Http\Requests\UpdatePasswordFormRequest;
use App\Http\Requests\UpdatePersonalInfoFormRequest;
use App\Http\Requests\UpdateUserPhotoFormRequest;
use App\Http\Requests\UpgradeKycLevelFormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use function Neosurf\format_currency;
use Neosurf\Responses\AuthResponse;
use Neosurf\Services\ClientService;

class ClientController extends Controller
{
    public function __construct(
        private readonly ClientService $clientService
    ) {
    }

    public function updateProfilePhoto(UpdateUserPhotoFormRequest $request)
    {
        try {
            $return = $this->clientService->uploadPhoto([
                'photo' => $request->file('photo'),
            ]);

            return response()->json($return);
        } catch (\Exception $e) {
            if (in_array($e->getCode(), [422, 412])) {
                $response = json_decode($e->response->getBody(), true);

                return response()->json([
                    'message' => $response['message'] ?? __('photos.upload_fail'),
                ], 412);
            }

            return response()->json([
                'message' => __('photos.upload_fail'),
            ], $e->getCode());
        }
    }

    public function closeAccountForm()
    {
        return view('close_account');
    }

    public function closeAccount(CloseAccountFormRequest $request)
    {
        $data = $request->validated();

        $this->clientService->closeAccount($data);

        $this->clientService->logout();

        AuthResponse::removeAuthCookies();

        return redirect()->route('login.form');
    }

    public function updatePersonalInfo(UpdatePersonalInfoFormRequest $request)
    {
        $data = $request->validated();
        try {
            $clientToken['user'] = $this->clientService->update(Auth::id(), $data);

            return response()->json($clientToken);
        } catch (\Exception $exception) {
            if (403 === $exception->getCode()) {
                return new JsonResponse([
                    'message' => __('messages.has_pending_request'),
                ], 403);
            }

            if ($exception->getCode() == 412) {
                $body = json_decode($exception->response->getBody(), true);
                if ($body['message'] == 'validation.unique_person') {
                    $body['message'] = __('messages.unique_person_error');
                }

                return response()->json($body, 412);
            }
            throw $exception;
        }
    }

    public function sessions(Request $request)
    {
        $sessions = $this->clientService->sessions();

        return view('pages.sessions')->with(['sessions' => $sessions]);
    }

    public function deleteSession(Request $request, $sessionId)
    {
        $this->clientService->deleteSession($sessionId);

        return redirect()->route('sessions');
    }

    public function updatePassword(UpdatePasswordFormRequest $request)
    {
        $data = $request->validated();
        $data['password_confirmation'] = $data['password'];

        return $this->clientService->updatePassword($data);
    }

    public function updateEmail(UpdateEmailFormRequest $request)
    {
        $data = $request->validated();
        $data['callback'] = route('confirm_update_email');
        if (auth()->user()->is_password_empty) {
            $data['password_confirmation'] = $data['password'];
        }

        return $this->clientService->updateEmail($data);
    }

    public function confirmEmailUpdate(ConfirmUpdateEmailRequest $request)
    {
        $data = $request->validated();
        $this->clientService->confirmEmailUpdate($data);
        Session::flash('message', ['alert-success' => __('messages.update_email.success')]);

        return redirect(route('home'));
    }

    public function upgradeAccountForm()
    {
        $client = Auth::user();
        $lastUserAccountLevel = $this->clientService->lastUserAccountLevel(Auth::id());
        $depositLimits = $this->clientService->getDepositLimits(auth()->id());
        $nextDepositLimits = $this->clientService->getNextDepositLimits(auth()->id());

        $levels = array_values(ClientService::LEVELS);
        $availableLevels = collect($levels)
            ->filter(function ($level, $index) use ($client, $levels) {
                return ($index <= array_search($client['max_level'], $levels)) && ! in_array($level, [ClientService::LEVELS['LIGHT'], ClientService::LEVELS['STARTER']]);
            })
            ->mapWithKeys(fn ($level) => [$level => $level])
            ->toArray();

        return view('pages.upgrade', [
            'client' => $client,
            'depositLimits' => $depositLimits,
            'nextDepositLimits' => $nextDepositLimits,
            'availableLevels' => $availableLevels,
            'lastUserAccountLevel' => $lastUserAccountLevel,
        ]);
    }

    public function getDepositLimits()
    {
        $limits = $this->clientService->getDepositLimits(auth()->id());
        $i = 0;
        foreach ($limits as $limit) {
            $limits[$i]['deposit_limit_per_time'] = format_currency($limit['deposit_limit_per_time'], $limit['currency']);
            $limits[$i]['daily_limit'] = format_currency($limit['daily_limit'], $limit['currency']);
            $limits[$i]['monthly_limit'] = format_currency($limit['monthly_limit'], $limit['currency']);
            $i++;
        }
        $result = [
            'limits' => $limits,
            'level' => Auth::user()->level,
        ];

        return response()->json($result);
    }

    public function upgradeAccount(UpgradeKycLevelFormRequest $request): RedirectResponse
    {
        $data = $request->validated();
        try {
            $data['access_id'] = config('microservices.access.key');
            $upgradeKycRequest = $this->clientService->upgradeClientKycLevel($data);
            $url = config('microservices.kyc_front.url').'/'.app()->getLocale().'/kyc-requests/'.
                $upgradeKycRequest['id'].'/'.config('app.upgrade_levels')[$data['level']]['kyc_front_url'];

            return redirect($url);
        } catch (\Exception $ex) {
            Session::flash('alert-danger', __('messages.upgrade_plan_fail'));

            return redirect()->back();
        }
    }

    public function generatePincode(): array
    {
        return $this->clientService->generatePincode();
    }

    public function changeLevel(ChangeLevelFormRequest $request)
    {
        $data = $request->validated();
        $this->clientService->changeLevel($data);
    }
}
