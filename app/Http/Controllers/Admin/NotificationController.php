<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PushSubscription;
use App\Models\PushMessage;
use Illuminate\Http\Request;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class NotificationController extends Controller
{
    public function index()
    {
        $messages = PushMessage::orderByDesc('created_at')->paginate(15);
        return view('admin.notifications.index', compact('messages'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function send(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'body' => 'required|string|max:200',
            'url' => 'nullable|url',
        ]);

        return $this->processSending($request->title, $request->body, $request->url);
    }

    public function resend(PushMessage $message)
    {
        return $this->processSending($message->title, $message->body, $message->url);
    }

    private function processSending($title, $body, $url)
    {
        $targetUrl = $url ?? url('/');
        $icon = asset('cyberlogo.jpg');

        $payload = json_encode([
            'title' => $title,
            'body' => $body,
            'icon' => $icon,
            'url' => $targetUrl,
        ]);

        $auth = [
            'VAPID' => [
                'subject' => env('VAPID_SUBJECT', 'mailto:admin@example.com'),
                'publicKey' => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
            ],
        ];

        if (!env('VAPID_PUBLIC_KEY') || !env('VAPID_PRIVATE_KEY')) {
            return back()->with('error', 'VAPID Keys hazijawekwa kwenye .env!');
        }

        $webPush = new WebPush($auth);
        $subscriptions = PushSubscription::all();

        foreach ($subscriptions as $sub) {
            $webPush->queueNotification(
                Subscription::create([
                    'endpoint' => $sub->endpoint,
                    'publicKey' => $sub->public_key,
                    'authToken' => $sub->auth_token,
                    'contentEncoding' => $sub->content_encoding,
                ]),
                $payload
            );
        }

        $successCount = 0;
        $failureCount = 0;

        foreach ($webPush->flush() as $report) {
            if ($report->isSuccess()) {
                $successCount++;
            } else {
                $failureCount++;
                // Optionally delete expired subscriptions here
                // PushSubscription::where('endpoint', $report->getRequest()->getUri()->__toString())->delete();
            }
        }

        PushMessage::create([
            'title' => $title,
            'body' => $body,
            'url' => $targetUrl,
            'success_count' => $successCount,
            'failure_count' => $failureCount,
        ]);

        return redirect()->route('admin.notifications.index')
            ->with('success', "Notification imetumwa! (Mafanikio: $successCount, Imefeli: $failureCount)");
    }
}
