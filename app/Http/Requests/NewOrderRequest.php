<?php

namespace App\Http\Requests;

use App\Aggregates\Buyer;
use App\Aggregates\Currency;
use App\Aggregates\Price;
use App\Aggregates\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

/**
 * Class NewOrderRequest
 * @package App\Http\Requests
 */
class NewOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contact_name'        => 'required|string',
            'contact_address'     => 'required|string',
            'contact_mobile'      => 'required|string',
            'contact_email'       => 'required|string',
            'products'            => 'required|array',
            'products.*.prod_oid' => 'required|integer',
            'products.*.qty'      => 'required|integer',
        ];
    }

    /**
     * @return Buyer
     */
    public function getBuyer(): Buyer
    {
        return Buyer::create(
            $this->get('contact_name'),
            $this->get('contact_address'),
            $this->get('contact_mobile'),
            $this->get('contact_email')
        );
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        $productInfoMap = [
            5566 => [
                'name'      => '卡茲爆米花黑松沙士口味',
                'unitPrice' => 25,
                'currency'  => 'TWD',
            ],
            7788 => [
                'name'      => "Lay's樂事樂連連義式搖烤披薩",
                'unitPrice' => 35,
                'currency'  => 'TWD',
            ],
        ];

        return collect($this->get('products'))->map(function ($item) use ($productInfoMap) {
            return Collection::times($item['qty'], function () use ($item, $productInfoMap) {
                return $this->createProduct(
                    $item['prod_oid'],
                    $productInfoMap[$item['prod_oid']]['name'],
                    $productInfoMap[$item['prod_oid']]['currency'],
                    $productInfoMap[$item['prod_oid']]['unitPrice']
                );
            })->all();
        })->collapse()
          ->all();
    }

    /**
     * @param int $prodOid
     * @param string $prodName
     * @param string $currency
     * @param int $unitPrice
     * @return Product
     */
    private function createProduct(int $prodOid, string $prodName, string $currency, int $unitPrice): Product
    {
        return Product::create(
            $prodOid,
            $prodName,
            Price::create(
                new Currency($currency),
                $unitPrice
            )
        );
    }
}
