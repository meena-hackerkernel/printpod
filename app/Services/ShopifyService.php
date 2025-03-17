<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ShopifyService
{
    protected $shopUrl;
    protected $accessToken;
    protected $apiVersion;

    public function __construct()
    {
        $this->shopUrl = env('SHOPIFY_STORE');
        $this->accessToken = env('SHOPIFY_ACCESS_TOKEN');
        $this->apiVersion = env('SHOPIFY_API_VERSION');
    }

    public function getOrders()
    {
        $url = "https://{$this->shopUrl}/admin/api/{$this->apiVersion}/orders.json?status=any";

        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->accessToken
        ])->get($url);

        return $response->json();
    }
}
