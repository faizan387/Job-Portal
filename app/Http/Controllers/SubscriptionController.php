<?php

namespace App\Http\Controllers;

use App\Http\Middleware\IsEmployer;
use App\Http\Middleware\UserPayment;
use App\Mail\PurchaseMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class SubscriptionController extends Controller
{
    const WEEKLY_AMOUNT = 20;
    const MONTHLY_AMOUNT = 50;
    const YEARLY_AMOUNT = 100;
    const CURRENCY = 'USD';

    public function __construct()
    {
        // middlewares inside construct applies to all methods in this class
        $this->middleware(['auth', IsEmployer::class]);
        // subscribe method won't apply the middleware functionality, all other methods will
        $this->middleware([UserPayment::class])->except(['subscribe']);
    }

    public function subscribe()
    {
        return view('subscription.index');
    }

    public function initiatePayment(Request $request)
    {
        $plans = [
            'weekly' => [
                'name' => 'weekly',
                'description' => 'weekly payment',
                'amount' => self::WEEKLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quantity' => 1,
            ],
            'monthly' => [
                'name' => 'monthly',
                'description' => 'monthly payment',
                'amount' => self::MONTHLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quantity' => 1,
            ],
            'yearly' => [
                'name' => 'yearly',
                'description' => 'yearly payment',
                'amount' => self::YEARLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quantity' => 1,
            ],
        ];

        Stripe::setApiKey(config('services.stripe.secret'));
        // intiate payment
        try {
            $selectedPlan = null;
            if ($request->is('pay/weekly')) {
                $selectedPlan = $plans['weekly'];
                $billendEndDate = now()->addWeek()->startOfDay()->toDateString();
            } elseif ($request->is('pay/monthly')) {
                $selectedPlan = $plans['monthly'];
                $billendEndDate = now()->addMonth()->startOfDay()->toDateString();
            } elseif ($request->is('pay/yearly')) {
                $selectedPlan = $plans['yearly'];
                $billendEndDate = now()->addYear()->startOfDay()->toDateString();
            }
            if ($selectedPlan) {
                // domain.com/plan=weekly&billing_ends=2024-03-23&signature=abc123
                $successUrl = URL::signedRoute('pay.success', [
                    'plan' => $selectedPlan['name'],
                    'billing_ends' => $billendEndDate,
                ]);
                $session = Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [
                        [
                            'quantity' => $selectedPlan['quantity'],
                            'price_data' => [
                                'unit_amount' => $selectedPlan['amount'] * 100, // stripe stores it as cents, so * by 100 to convert to USD
                                'currency' => $selectedPlan['currency'],
                                'product_data' => [
                                    'name' => $selectedPlan['name'],
                                    'description' => $selectedPlan['description'],
                                ],
                            ],
                        ],
                    ],
                    'mode' => 'payment',
                    'success_url' => $successUrl,
                    'cancel_url' => route('pay.cancel'),
                ]);
                return redirect($session->url);
            }
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $plan = $request->plan;
        $billingEnd = $request->billing_ends;
        User::where('id', auth()->user()->id)->update([
            'plan' => $plan,
            'billing_ends' => $billingEnd,
            'status' => 'paid',
        ]);
        try {
            Mail::to(auth()->user())->queue(new PurchaseMail($plan, $billingEnd));
        } catch (\Exception $e) {
            return response()->json($e);
        }
        return redirect()->route('dashboard')->with('successMessage', 'Payment was successful');
    }

    public function paymentCancel(Request $request)
    {
        return redirect()->route('dashboard')->with('errorMessage', 'Payment was unsuccessful');
    }
}
