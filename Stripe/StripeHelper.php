<?php

namespace App\Custom;

use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Stripe\Error\Card;

use Validator;
use Session;
use Auth;

class StripeHelper {
	/* Private global variables */
	private $amount;

	/* Public functions */
	public function __construct($amount = 0) {
		$this->amount = $amount;
	}

	public function one_time_charge($data) {
		// Get amount from either
		if ($this->amount == 0) {
			$amount = $data["amount"];
		} else {
			$amount = $this->amount;
		}

		// Start by creating a charge
		$stripe = Stripe::make(env('STRIPE_SECRET'));

		try {
			// Create the token
			$token = $stripe->tokens()->create([
				'card' => [
					'number'    => $data["card_number"],
					'exp_month' => $data["ccExpiryMonth"],
					'exp_year'  => $data["ccExpiryYear"],
					'cvc'       => $data["cvvNumber"]
				]
			]);

			if (!isset($token['id'])) {
				\Session::put('error','The Stripe Token was not generated correctly');
				return redirect()->back();
			}

			// Check to see if customer ID need to be re-generated
			if(isset($data["customer_id"])) {
				try {
					$customer = $stripe->customers()->find($customer_id);
				} catch (Exception $e) {
					// Create a customer
					$customer = $stripe->customers()->create([
						"email" => $data["email"]
					]);
				}
			} else {
				// Create a customer
				$customer = $stripe->customers()->create([
					"email" => $data["email"]
				]);
			}

			// Create a card for customer
			$card = $stripe->cards()->create($customer["id"], $token["id"]);

			$charge = $stripe->charges()->create([
				'customer' => $customer["id"],
				'currency' => 'USD',
				'amount'   => $amount,
				'description' => $data["description"]
			]);

			if($charge['status'] == 'succeeded') {
				return "success";
			} else {
				return "error";
			}
		} catch (Exception $e) {
			return $e->getMessage();
		} catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
			return $e->getMessage();
		} catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
			return $e->getMessage();
		}
	}

	public function subscribe($data) {
		// Start by creating a charge
		$stripe = Stripe::make(env('STRIPE_SECRET'));

		try {
			// Create the token
			$token = $stripe->tokens()->create([
				'card' => [
					'number'    => $data["card_number"],
					'exp_month' => $data["ccExpiryMonth"],
					'exp_year'  => $data["ccExpiryYear"],
					'cvc'       => $data["cvvNumber"]
				]
			]);

			if (!isset($token['id'])) {
				\Session::put('error','The Stripe Token was not generated correctly');
				return redirect()->back();
			}

			// Check to see if customer ID need to be re-generated
			if(isset($data["customer_id"])) {
				try {
					$customer = $stripe->customers()->find($customer_id);
				} catch (Exception $e) {
					// Create a customer
					$customer = $stripe->customers()->create([
						"email" => $data["email"]
					]);
				}
			} else {
				// Create a customer
				$customer = $stripe->customers()->create([
					"email" => $data["email"]
				]);
			}

			// Create a card for customer
			$card = $stripe->cards()->create($customer["id"], $token["id"]);

			$subscription = $stripe->subscriptions()->create($customer["id"], [
			    'plan' => $data["plan_id"]
			]);

			if($subscription['status'] == 'active') {
				return "success";
			} else {
				return "error";
			}
		} catch (Exception $e) {
			return $e->getMessage();
		} catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
			return $e->getMessage();
		} catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
			return $e->getMessage();
		}
	}

	public function check_subscription($customer_id, $subscription_id) {
		$stripe = Stripe::make(env('STRIPE_SECRET'));
		$subscription = $stripe->subscriptions()->find($customer_id, $subscription_id);
		return $subscription['status'];
	}

	public function make_plan($data) {
		$stripe = Stripe::make(env('STRIPE_SECRET'));
		$plan = $stripe->plans()->create([
	    	'id' => $data["plan_id"],
		    'name' => $data["plan_name"],
		    'amount' => $data["plan_amount"],
		    'currency' => $data["plan_currency"],
		    'interval' => $data["plan_interval"],
		    'statement_descriptor' => $data["plan_descriptor"]
		]);
		return $plan;
	}
}