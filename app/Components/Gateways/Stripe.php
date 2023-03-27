<?php

namespace App\Components\Gateways;

use Stripe\Token;
use Stripe\Charge;
use App\Models\Plan;
use Stripe\Customer;
use Illuminate\Http\Request;
use App\Contracts\GatewayInterface;
use Stripe\Stripe as StripeGateway;

class Stripe implements GatewayInterface
{
    protected $stripe;
    protected $config;
    protected $stripeConfig;
    protected $request;
    protected $stripeToken;

    public function __construct(Request $request, array $config)
    {
        $this->request = $request;
        $this->config = $config;
    }

    public function isActive(): bool
    {
        return (bool) setting('STRIPE_ALLOW', 0);
    }

    public function isConfigured(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return "Credit or Debit Card";
    }



    public function getIcon(): string
    {
        return '<i class="an an-stripe-card"></i>';
    }

    public function initialize()
    {
        $this->stripe = new \Stripe\StripeClient($this->config['secretKey']);
    }

    public function render()
    {
        return view('checkout.stripe')->render();
    }

    public function processPayment($transaction)
    {
        $request = $this->request;
        $plan_id = $request->plan_id;
        StripeGateway::setApiKey($this->config['secretKey']);
        $this->stripeToken = $this->createStripeToken();
        if ($plan_id == 0) {
            $plan = ads_plan();
        } else {
            $plan = Plan::find($request->plan_id); //get from plan db
        }
        if ($request->type == "yearly") {
            $amount = $plan->yearly_price;
            $var_type = "year";
        } else {
            $amount = $plan->monthly_price;
            $var_type = "month";
        }
        $customer = Customer::create([
            'name' => $request->first_name,
            'address' => [
                'line1' => $request->address_lane_1,
                'postal_code' => $request->postal_code,
                'country' => $request->country_code,
            ],
            'email' => $request->email,
            'source' => $this->stripeToken
        ]);
        $customer_id = $customer->id;
        $stripe = $this->stripe;
        //create product
        $product = $stripe->products->create([
            'name' => $plan->name,
        ]);
        $product_id = $product->id;
        $price = $stripe->prices->create([
            'unit_amount' => str_replace([',', '.'], ['', ''], $amount),
            'currency' => \Setting('currency', "USD"),
            'recurring' => ['interval' => $var_type],
            'product' => $product_id,
        ]);
        $price_id = $price->id;
        $subscription = $stripe->subscriptions->create([
            'customer' => $customer_id,
            'items' => [
                ['price' => $price_id],
            ],
        ]);

        if (isset($subscription->id)) {
            $transaction->transaction_id = $subscription->id; // update the transaction id for the database
            $transaction->update();
            return redirect()->route("payments.success", $transaction->id);
        } else {
            return redirect()->route("payments.cancel", $transaction->id);
        }
    }

    public function createStripeToken()
    {
        $request = $this->request;
        $number    = $request->card_no;
        $exp_month = $request->exp_month;
        $exp_year  = $request->exp_year;
        $cvc      = $request->card_cvc;
        $name      = $request->name_card;
        try {
            $response = Token::create(array(
                "card" => array(
                    "number"    => $number,
                    "exp_month" => $exp_month,
                    "exp_year"  => $exp_year,
                    "cvc"       => $cvc,
                    "name"      => $name
                )
            ));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
        $res = $response->toArray();
        $token = $res['id'];
        return $token;
    }
}
