<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    //

    public function generateQrCode(Request $request) {
        $uri = "https://pg-sandbox.paymaya.com/payments/v1/qr/payments";
        $username = "pk-rpwb5YR6EfnKiMsldZqY4hgpvJjuy8hhxW2bVAAiz2N";
        $body = [
            "totalAmount" => [
                "value" => $request->amount,
                "currency" => "PHP",
            ],
            "redirectUrl" => [
                "success" => "www.youtube.com",
                "failure" => "www.facebook.com",
                "cancel" => "www.twitter.com"
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
