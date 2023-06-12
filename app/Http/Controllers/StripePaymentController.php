<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

// Stripe Composer Library
use Stripe;

class StripePaymentController extends Controller
{
    //Stripe API Integration
    public function stripePost(Request $request)
    {
        try{
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );

            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $response = $stripe->charges->create([
                'amount' => $request->amount,
                'currency' => 'usd',    
                'source' => $request->source,
                'description' => $request->description,
            ]);

            return response()->json($response->status, 200);
        }
        catch(Exception $e){
            return response()->json([['response' => 'error', 'message' => $e->getMessage()]], 500);
        }
    }
}
