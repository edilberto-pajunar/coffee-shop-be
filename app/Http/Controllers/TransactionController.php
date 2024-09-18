<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\call;

class TransactionController extends Controller
{
    public function show() {
        $user = Auth::user();
        $transactions = $user->transactions()->orderBy('created_at', 'desc')
            ->paginate(10);

        try {
            return response()->json([
                "status" => "success",
                "data" => $transactions,
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                "status" => "error",
                "message" => $e->getMessage(),
            ]);
        }
    }
}
