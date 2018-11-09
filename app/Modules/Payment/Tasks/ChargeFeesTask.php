<?php namespace App\Modules\Payment\Tasks;


class ChargeFeesTask
{
    /**
     * @var int
     */
    private $percentage = 27;

    /**
     * @var
     */
    private $price;

    /**
     * ChargeFeesTask constructor.
     * @param $price
     */
    public function __construct($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        $fees = ( $this->percentage / 100 * $this->price);

        return ($this->price - $fees);
    }
}