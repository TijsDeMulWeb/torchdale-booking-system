<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $orderInfo = $request->input();
        $customerInput = $request->input('customer');

        $customer = $this->matchOrCreateCustomer($request->escaperoom, $customerInput, $request->ip());
        
        if ($customer->banned_at) {
            return response()->json(['success' => false, 'message' => 'Customer isn\'t allowed to place an order.'], 403);
        }

        return response()->json(['success' => true, 'info' => $orderInfo, 'customer' => $customer, 'ip' => $request->ip()]);
    }

    private function matchOrCreateCustomer($escaperoom, array $input, ?string $ip): Customer
    {
        $candidates = $escaperoom->customers()
            ->where(function ($q) use ($input, $ip) {
                $q->where('email', $input['email'] ?? '')
                  ->orWhere(function ($q) use ($input) {
                      if (!empty($input['phone'])) {
                          $q->where('phone', $input['phone']);
                      }
                  })
                  ->orWhere(function ($q) use ($input) {
                      if (!empty($input['first_name']) && !empty($input['last_name'])) {
                          $q->where('first_name', $input['first_name'])
                            ->where('last_name', $input['last_name']);
                      }
                  })
                  ->orWhere(function ($q) use ($ip) {
                      if ($ip) {
                          $q->where('ip_address', $ip);
                      }
                  });
            })
            ->get();

        $best = null;
        $bestScore = 0;

        foreach ($candidates as $candidate) {
            $score = 0;

            if (!empty($input['email']) && $candidate->email === $input['email']) {
                $score += 60;
            }
            if (!empty($input['phone']) && $candidate->phone === $input['phone']) {
                $score += 50;
            }
            if (!empty($input['first_name']) && !empty($input['last_name'])
                && $candidate->first_name === $input['first_name']
                && $candidate->last_name === $input['last_name']) {
                $score += 30;
            }
            if (!empty($input['city']) && $candidate->city === $input['city']) {
                $score += 10;
            }
            if (!empty($input['street']) && $candidate->street === $input['street']) {
                $score += 10;
            }
            if ($ip && $candidate->ip_address === $ip) {
                $score += 15;
            }

            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $candidate;
            }
        }

        if ($best && $bestScore >= 50) {
            return $best;
        }

        return $escaperoom->customers()->create(array_merge(
            array_intersect_key($input, array_flip([
                'first_name', 'last_name', 'email', 'phone',
                'street', 'house_number', 'postal_code', 'city', 'country',
            ])),
            ['ip_address' => $ip]
        ));
    }
}
