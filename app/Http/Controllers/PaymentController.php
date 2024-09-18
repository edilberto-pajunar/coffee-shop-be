<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use function Pest\Laravel\call;

class PaymentController extends Controller
{
    //

    public function generateQrCode(Request $request) {
        $uri = "https://pg-sandbox.paymaya.com/payby/v2/paymaya/payments";
        $username = "pk-rpwb5YR6EfnKiMsldZqY4hgpvJjuy8hhxW2bVAAiz2N";
        $body = [
            "totalAmount" => [
                "value" => $request->amount,
                "currency" => "PHP",
            ],
            "redirectUrl" => [
                "success" => "http://127.0.0.1:8000/success",
                "failure" => "http://127.0.0.1:8000/failed",
                "cancel" => "http://127.0.0.1:8000/cancelled"
            ],
            "requestReferenceNumber" => "1",
            "metadata" => [
                "pf" => [
                    "smi" => "PHP",
                    "smn" => "PHP",
                    "mci" => "PHP",
                    "mpc" => "608",
                    "mco" => "PHL"
                ]
            ]
        ];

        $response = Http::withBasicAuth($username, "")
            ->post($uri, $body);

        $data = $response->json();

        if ($response->successful()) {

            return response()->json([
                'status' => "success",
                "data" => $data,
            ], 200);
        } else {
            return response()->json([
                'status' => "failed",
                "data" => $data,
            ], $response->status());
        }
    }
}
