<?php
declare(strict_types = 1);

namespace App\Entity;

class TickerData
{
    private $m_companyName;
    private $m_primaryExchange;
    private $m_sector;
    private $m_previousClose;
    private $m_openTime;
    private $m_open;
    private $m_latestPrice;
    private $m_change;
    private $m_latestUpdate;
    private $m_high;
    private $m_low;
    private $m_close;
    private $m_closeTime;
    private $m_extendedPrice;
    private $m_extendedPriceTime;
    private $m_week52Low;
    private $m_week52High;

    /**
     *
     * @param string $companyName
     * @param string $primaryExchange
     * @param string $sector
     * @param float $previousClose
     * @param int $openTime
     * @param float $open
     * @param float $latestPrice
     * @param float $change
     * @param int $latestUpdate
     * @param float $high
     * @param float $low
     * @param float $close
     * @param int $closeTime
     * @param float $extendedPrice
     * @param int $extendedPriceTime
     * @param float $week52Low
     * @param float $week52High
     */
    public function __construct( $companyName,
        $primaryExchange,
        $sector,
        $previousClose,
        $openTime,
        $open,
        $latestPrice,
        $change,
        $latestUpdate,
        $high,
        $low,
        $close,
        $closeTime,
        $extendedPrice,
        $extendedPriceTime,
        $week52Low,
        $week52High )
    {
        $this->m_companyName = $companyName;
        $this->m_primaryExchange = $primaryExchange;
        $this->m_sector = $sector;
        $this->m_previousClose = $previousClose;
        $this->m_openTime = $openTime;
        $this->m_open = $open;
        $this->m_latestPrice = $latestPrice;
        $this->m_change = $change;
        $this->m_latestUpdate = $latestUpdate;
        $this->m_high = $high;
        $this->m_low = $low;
        $this->m_close = $close;
        $this->m_closeTime = $closeTime;
        $this->m_extendedPrice = $extendedPrice;
        $this->m_extendedPriceTime = $extendedPriceTime;
        $this->m_week52Low = $week52Low;
        $this->m_week52High = $week52High;
    }

    /**
     *
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->m_companyName;
    }

    /**
     *
     * @return string
     */
    public function getPrimaryExchange(): string
    {
        return $this->m_primaryExchange;
    }

    /**
     *
     * @return string
     */
    public function getSector(): string
    {
        return $this->m_sector;
    }

    /**
     *
     * @return float
     */
    public function getPreviousClose(): float
    {
        return $this->m_previousClose;
    }

    /**
     *
     * @return int
     */
    public function getOpenTime(): int
    {
        return $this->m_openTime;
    }

    /**
     * 
     * @return float
     */
    public function getOpen(): float
    {
        return $this->m_open;
    }

    /**
     *
     * @return float
     */
    public function getLatestPrice(): float
    {
        return $this->m_latestPrice;
    }

    /**
     *
     * @return float
     */
    public function getChange(): float
    {
        return $this->m_change;
    }

    /**
     *
     * @return int
     */
    public function getLatestUpdate(): int
    {
        return $this->m_latestUpdate;
    }

    /**
     *
     * @return float
     */
    public function getHigh(): float
    {
        return $this->m_high;
    }

    /**
     *
     * @return float
     */
    public function getLow(): float
    {
        return $this->m_low;
    }

    /**
     *
     * @return float
     */
    public function getClose(): float
    {
        return $this->m_close;
    }

    /**
     *
     * @return int
     */
    public function getCloseTime(): int
    {
        return $this->m_closeTime;
    }

    /**
     *
     * @return float
     */
    public function getExtendedPrice(): float
    {
        return $this->m_extendedPrice;
    }

    /**
     *
     * @return int
     */
    public function getExtendedPriceTime(): int
    {
        return $this->m_extendedPriceTime;
    }

    /**
     *
     * @return float
     */
    public function getWeek52Low(): float
    {
        return $this->m_week52Low;
    }

    /**
     *
     * @return float
     */
    public function getWeek52High(): float
    {
        return $this->m_week52High;
    }

    /**
     *
     * @param string $companyName
     */
    public function setCompanyName( string $companyName )
    {
        $this->m_companyName = $companyName;
    }

    /**
     *
     * @param string $primaryExchange
     */
    public function setPrimaryExchange( string $primaryExchange )
    {
        $this->m_primaryExchange = $primaryExchange;
    }

    /**
     *
     * @param string $sector
     */
    public function setSector( string $sector )
    {
        $this->m_sector = $sector;
    }

    /**
     *
     * @param float $previousClose
     */
    public function setPreviousClose( float $previousClose )
    {
        $this->m_previousClose = $previousClose;
    }

    /**
     *
     * @param int $openTime
     */
    public function setOpenTime( int $openTime )
    {
        $this->m_openTime = $openTime;
    }

    /**
     *
     * @param float $open
     */
    public function setOpen( float $open )
    {
        $this->m_open = $open;
    }

    /**
     *
     * @param float $latestPrice
     */
    public function setLatestPrice( float $latestPrice )
    {
        $this->m_latestPrice = $latestPrice;
    }

    /**
     *
     * @param float $change
     */
    public function setChange( float $change )
    {
        $this->m_change = $change;
    }

    /**
     *
     * @param int $latestUpdate
     */
    public function setLatestUpdate( int $latestUpdate )
    {
        $this->m_latestUpdate = $latestUpdate;
    }

    /**
     *
     * @param float $high
     */
    public function setHigh( float $high )
    {
        $this->m_high = $high;
    }

    /**
     *
     * @param float $low
     */
    public function setLow( float $low )
    {
        $this->m_low = $low;
    }

    /**
     *
     * @param float $close
     */
    public function setClose( float $close )
    {
        $this->m_close = $close;
    }

    /**
     *
     * @param int $closeTime
     */
    public function setCloseTime( int $closeTime )
    {
        $this->m_closeTime = $closeTime;
    }

    /**
     *
     * @param float $extendedPrice
     */
    public function setExtendedPrice( float $extendedPrice )
    {
        $this->m_extendedPrice = $extendedPrice;
    }

    /**
     *
     * @param int $extendedPriceTime
     */
    public function setExtendedPriceTime( int $extendedPriceTime )
    {
        $this->m_extendedPriceTime = $extendedPriceTime;
    }

    /**
     *
     * @param float $week52Low
     */
    public function setWeek52Low( float $week52Low )
    {
        $this->m_week52Low = $week52Low;
    }

    /**
     *
     * @param float $week52High
     */
    public function setWeek52High( float $week52High )
    {
        $this->m_week52High = $week52High;
    }
}
