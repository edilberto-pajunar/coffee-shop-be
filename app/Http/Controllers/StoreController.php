<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StoreController extends Controller
{
    public function index() : JsonResponse {
        $locations = Store::all();

        return response()->json([
            "status" => "success",
            "data" => $locations,
        ], 200);
    }

    public function stream(Request $request) {

        try {
            $response = new StreamedResponse(function() {
                while (true) {
                    $data = [
                        "location" => [
                            "latitude" => request("latitude"),
                            "longitude" => request("longitude"),
                        ],
                        "message" => "Your current location is being streamed",
                    ];
    
                    echo "data: " . json_encode($data) . "\n\n";
                    ob_flush();
                    flush();
                    sleep(5);
                }
            });
    
            $response->headers->set("Content-Type", "text/event-stream");
            $response->headers->set("Cache-Control", "no-cache");
            $response->headers->set("Connection", "keep-alive");

            return response()->json([
                "status" => "success",
                "data" => $response,
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                "status" => "error",
                "message" => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request) {
        try {
            $location = Store::create([
                "name" => "helo",
                "address" => "address",
                "phone" => "+123",
                "email" => "test@gmail.com",
                "website" => "test.com",
                "description" => "test description",
                "image" => "test.png",
                "status" => true,
                "opening_hours" => "10:00:00",
                "closing_hours" => "18:00:00",
                "open_24_hours" => true,
                "lat" => $request->input("latitude"),
                "lng" => $request->input("longitude"),
            ]);

            return response()->json([
                "status" => "success",
                "data" => $location,
            ], 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
