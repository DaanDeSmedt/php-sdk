<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest;

use Money\Money;
use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PaymentOptions;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable;
use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class Redirect
 * @package MultiSafepay\Api\Transactions\OrderRequest
 */
class Redirect extends OrderRequest
{
    /**
     * @var string
     */
    protected $type = 'redirect';

    /**
     * @var ShoppingCart
     */
    protected $shoppingCart;

    /**
     * @var CustomerDetails
     */
    protected $customer;

    /**
     * @var CustomerDetails
     */
    protected $delivery;

    /**
     * @var TaxTable
     */
    private $taxTable;

    /**
     * @param ShoppingCart $shoppingCart
     */
    public function addShoppingCart(ShoppingCart $shoppingCart): void
    {
        $this->shoppingCart = $shoppingCart;
    }

    /**
     * @param CustomerDetails $customer
     */
    public function addCustomer(CustomerDetails $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @param CustomerDetails $delivery
     */
    public function addDelivery(CustomerDetails $delivery): void
    {
        $this->delivery = $delivery;
    }

    /**
     * @param TaxTable $taxTable
     */
    public function addTaxTable(TaxTable $taxTable): void
    {
        $this->taxTable = $taxTable;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $data = parent::getData();
        $data['customer'] = ($this->customer) ? $this->customer->getData() : null;
        $data['delivery'] = ($this->delivery) ? $this->delivery->getData() : null;
        $data['shopping_cart'] = ($this->shoppingCart) ? $this->shoppingCart->getData() : null;
        $data['checkout_options'] = $this->getCheckoutOptions();

        return $data;
    }

    /**
     * @return array
     */
    private function getCheckoutOptions(): array
    {
        if ($this->taxTable) {
            return [
                'tax_tables' => $this->taxTable->getData()
            ];
        }

        return [];
    }

    /**
     * @return bool
     */
    protected function validate(): bool
    {
        parent::validate();

        if (!$this->shoppingCart && $this->taxTable) {
            throw new InvalidArgumentException('Shopping cart is required when adding a tax table');
        }

        if (!$this->taxTable && $this->shoppingCart) {
            throw new InvalidArgumentException('Tax table is required when adding a shopping cart');
        }

        return true;
    }
}
