<?php

namespace App\Http\Controllers\Web\Back\Users\Ai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ai;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    public function index()
    {
        $check = Ai::where('user_id', auth()->user()->id )->first();

        $date = date("Y-m-d");

        if (!$check) {
            Ai::create([
                'user_id' => auth()->user()->id,
                'message' => '0',
                'date' => $date
            ]);
            $remaining = 10000;
        } else {
            $user_date = $check->date;
            $remaining = 10000 - $check->message;
            if ($user_date < $date) {
                $check->date = $date;
                $check->message = '0';
                $check->save();
            }
        }

        return view('themes.default.back.users.ai.ai', [
            'remaining' => $remaining,
        ]);
    }

    public function get_remaining ()
    {
        $remaining = Ai::where('user_id', auth()->user()->id)->sum('message');
        $remaining = 10000 - $remaining;
        return $remaining;
    }


    public function message(Request $request) {
        $ai_chat = Ai::where('user_id', auth()->user()->id)->first();

        if ($ai_chat->message >= 10000) {
            return response()->json(['error' => 'Reached limit'], 400);
        }

        $message = $request->message;
        $context = json_decode($request->context ?? '[]', true);

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyCVoxgBTlZACBES2I9W8CLQRDbNEYudBXg';

        // Build conversation history
        $contents = [];

        // Add previous conversation context if available
        if (!empty($context)) {
            foreach ($context as $exchange) {
                if (isset($exchange[0]) && isset($exchange[1])) {
                    $contents[] = [
                        'role' => 'user',
                        'parts' => [['text' => $exchange[0]]]
                    ];
                    $contents[] = [
                        'role' => 'model',
                        'parts' => [['text' => $exchange[1]]]
                    ];
                }
            }
        }

        // Add current message
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $message]]
        ];

        $data = [
            'contents' => $contents
        ];

        try {
            $response = Http::post($url, $data);
            $complete = json_decode($response->body());

            // Handle new Gemini 2.0 response format
            if (isset($complete->candidates[0]->content->parts[0]->text)) {
                $text = $complete->candidates[0]->content->parts[0]->text;
            } elseif (isset($complete->error->message)) {
                $text = $complete->error->message;
            } else {
                $text = "Sorry, but I don't know how to answer that.";
            }

            // Calculate token usage from new format
            if (isset($complete->usageMetadata) && isset($complete->usageMetadata->totalTokenCount)) {
                $total_tokens = $complete->usageMetadata->totalTokenCount;
                $total_tokens = $total_tokens * 1.34;
            } else {
                $total_tokens = 0;
            }

            $ai_chat->update(['message' => floor($ai_chat->message + $total_tokens)]);

            // Convert markdown to HTML
            $converter = new CommonMarkConverter();
            $styled = $converter->convert($text);

            // Return the response
            return [
                "message" => (string)$styled,
                "raw_message" => $text,
                "status" => "success"
            ];
        } catch (\Exception $e) {
            return [
                "message" => "An error occurred while processing your request.",
                "raw_message" => "Error: " . $e->getMessage(),
                "status" => "error"
            ];
        }
    }

    public function messageGpt(Request $request)
    {
        $ai_chat = Ai::where('user_id', auth()->user()->id)->first();

        if ($ai_chat->message >= 10000) {
            return response()->json(['error' => 'Reached limit'], 400);
        }

        $message = $request->message;
        $context = json_decode($request->context ?? '[]', true);

        $url = 'https://api.openai.com/v1/chat/completions';

        // Build conversation messages
        $messages = [];

        // Add previous conversation context if available
        if (!empty($context)) {
            foreach ($context as $exchange) {
                if (isset($exchange[0]) && isset($exchange[1])) {
                    $messages[] = [
                        'role' => 'user',
                        'content' => $exchange[0]
                    ];
                    $messages[] = [
                        'role' => 'assistant',
                        'content' => $exchange[1]
                    ];
                }
            }
        }

        // Add current message
        $messages[] = [
            'role' => 'user',
            'content' => $message
        ];

        $data = [
            'model' => 'gpt-4o-mini',
            'messages' => $messages
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer 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'
        ];

        try {
            $response = Http::withHeaders($headers)->post($url, $data);
            $complete = json_decode($response->body());

            if (isset($complete->choices[0]->message) && isset($complete->choices[0]->message->content)) {
                $text = str_replace("\\n", "\n", $complete->choices[0]->message->content);
            } elseif (isset($complete->error->message)) {
                $text = $complete->error->message;
            } else {
                $text = "Sorry, but I don't know how to answer that.";
            }

            if (isset($complete->usage) && isset($complete->usage->total_tokens)) {
                $total_tokens = $complete->usage->total_tokens;
                $total_tokens = $total_tokens * 1.34;
            } else {
                $total_tokens = 0;
            }

            $ai_chat->update(['message' => floor($ai_chat->message + $total_tokens)]);

            // Convert markdown to HTML
            $converter = new CommonMarkConverter();
            $styled = $converter->convert($text);

            // Return the response
            return [
                "message" => (string)$styled,
                "raw_message" => $text,
                "status" => "success"
            ];
        } catch (\Exception $e) {
            return [
                "message" => "An error occurred while processing your request.",
                "raw_message" => "Error: " . $e->getMessage(),
                "status" => "error"
            ];
        }
    }
}