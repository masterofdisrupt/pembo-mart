<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Google\Auth\ApplicationDefaultCredentials;
use App\Models\Backend\V1\NotificationModel;
use GuzzleHttp\Client;
use App\Models\User;
use Exception;



class NotificationController
{
     public function notification_index(Request $request)
    {
        $data['getRecord'] = User::get();
        return view('backend.admin.notification.update', $data);
    }

   
   public function notification_send(Request $request)
{
    $saveDb = new NotificationModel;
    $saveDb->user_id = trim($request->user_id);
    $saveDb->title = trim($request->title);
    $saveDb->message = trim($request->message);
    $saveDb->save();

    $user = User::where('id', $request->user_id)->first();
    

    if (!empty($user->token)) {
        try {
            // Generate Access Token using Google Client
            $client = new \Google\Client();
            $client->setAuthConfig(getenv('GOOGLE_APPLICATION_CREDENTIALS'));
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];


            // Firebase API URL
            $url = "https://fcm.googleapis.com/v1/projects/pembo-mart/messages:send";

            // Build Notification Payload
            $notification = [
                'message' => [
                    'token' => $user->token,
                    'notification' => [
                        'title' => $request->title,
                        'body' => $request->message,
                    ],
                    'data' => [
                        'title' => $request->title,
                        'message' => $request->message,
                    ],
                ],
            ];

            // Make the HTTP Request
            $client = new Client();
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $notification,
            ]);

            if ($response->getStatusCode() == 200) {
                return redirect(route('notification'))->with('success', "Notification Successfully Sent!");
            } else {
                return redirect(route('notification'))->with('error', "Failed to send notification.");
            }

        } catch (\Exception $e) {
            return redirect(route('notification'))->with('error', "Error: " . $e->getMessage());
        }
    }

    return redirect(route('notification'))->with('error', "User does not have a valid token.");
}

}


