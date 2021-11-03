<?php

namespace App\Http\Controllers;

use App\Http\Requests\forgetPasswordEmailSentRequest;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class authMailController extends Controller
{
    //
    use SendsPasswordResetEmails;

    public function sendPasswordResetLink(forgetPasswordEmailSentRequest $request)
    {


        return $this->sendResetLinkEmail($request);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    public function gettingtoken($token)
    {
        return redirect()->to("http://localhost:8081/pages/authentication/ResetPasswordToken/$token");
    }
}
