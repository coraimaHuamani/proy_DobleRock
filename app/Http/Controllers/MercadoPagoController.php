<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

class MercadoPagoController extends Controller
{
    public function checkout(Request $request)
    {
        try {
            MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));

            $productos = $request->input('productos', []);
            $items = [];
            foreach ($productos as $prod) {
                $items[] = [
                    'title' => $prod['name'],
                    'quantity' => $prod['qty'],
                    'unit_price' => $prod['price'],
                ];
            }

            $ngrokUrl = 'https://89ac3ce7abb2.ngrok-free.app';

            $preferenceClient = new PreferenceClient();
            $preference = $preferenceClient->create([
                'items' => $items,
                'back_urls' => [
                    'success' => $ngrokUrl . '/mercadopago/success',
                    'failure' => $ngrokUrl . '/mercadopago/failure',
                    'pending' => $ngrokUrl . '/mercadopago/pending',
                ],
                'auto_return' => 'approved',
            ]);

            return response()->json(['init_point' => $preference->init_point]);
        } catch (MPApiException $e) {
            \Log::error('MercadoPago error: ' . json_encode($e->getApiResponse()->getContent()));
            return response()->json(['error' => $e->getApiResponse()->getContent()], 500);
        }
    }
}
