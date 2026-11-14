<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * POST /{locale}/contact, throttled at 5/min by the route definition.
 *
 * ponytail: validation, the Inquiry model and the two queued mails are not
 * built. 501 makes an unbuilt endpoint loud instead of silently accepting and
 * dropping a real enquiry. Implement against AC-19/AC-23 before launch.
 */
class ContactController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Contact endpoint not implemented.',
        ], 501);
    }
}
