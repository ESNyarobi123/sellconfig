<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use Illuminate\Http\Request;

class PushController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|url',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
        ]);

        $endpoint = $request->input('endpoint');
        $key = $request->input('keys.p256dh');
        $token = $request->input('keys.auth');
        $encoding = $request->input('encoding', 'aes128gcm');

        // Check if exists
        $sub = PushSubscription::firstOrNew(['endpoint' => $endpoint]);

        $sub->user_id = auth()->id(); // Nullable
        $sub->public_key = $key;
        $sub->auth_token = $token;
        $sub->content_encoding = $encoding;

        $sub->save();

        return response()->json(['success' => true]);
    }
}
