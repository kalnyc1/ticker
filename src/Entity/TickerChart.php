<?php
declare(strict_types = 1);

namespace App\Entity;

class TickerChart
{
    /**
     * @var string
     */
    private $m_label;
    
    
    /**
     * @var float
     */
    private $m_close;
    
    /**
     * 
     * @param string $label
     * @param float $close
     */
    public function __construct( $label, $close )
    {
        $this->m_label = $label;
        $this->m_close = $close;
    }
    
    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->m_label;
    }
    
    /**
     * @return float
     */
    public function getClose(): ?float
    {
        return $this->m_close;
    }
    
    /**
     * @param string $label
     */
    public function setLabel( string $label )
    {
        $this->m_label = $label;
    }
    
    /**
     * @param float $close
     */
    public function setClose( ?float $close )
    {
        $this->m_close = $close;
    }
}
