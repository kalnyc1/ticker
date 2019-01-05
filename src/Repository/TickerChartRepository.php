<?php
declare(strict_types = 1);

namespace App\Repository;

use App\Entity\TickerChart;
use App\Serialization\ChartObjectNormalizer;
use App\Serialization\ChartArrayDenormalizer;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use GuzzleHttp;

class TickerChartRepository
{
    /**
     * @var LoggerInterface
     */
    private $m_logger = null;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct( LoggerInterface $logger )
    {
        $this->m_logger = $logger;
    }
    
    /**
     * Get the symbol ticker chart.
     * @param string $symbol
     * @return TickerChart[]
     */
    public function getTickerChart( GuzzleHttp\Client $client, string $symbol, ?string $date ): ?array
    {
        if ( is_null( $date ) ) {
            // Create endpoint
            $endPoint = 'stock/' . $symbol . '/chart/1d?chartInterval=1';
        }
        else {
            // Create endpoint
            $endPoint = 'stock/' . $symbol . '/chart/date/' . $date . '?chartInterval=1';
        }
        
        $clientResp = $client->request( 'GET', $endPoint );
        $this->m_logger->debug( "STATUS: " . $clientResp->getStatusCode() );
        
        if ( $clientResp->getStatusCode() != 200 ) {
            return null;
        }

        $responseBody = $clientResp->getBody()->getContents();
        
        // We could easily use json_decode to do this, but
        // lets have some fun and use deserialization classes.
        $encoder = [new JsonEncoder()];
        $normalizer = [new ChartObjectNormalizer(), new ChartArrayDenormalizer()];
        
        $serializer = new Serializer( $normalizer, $encoder );
        
        return $serializer->deserialize( $responseBody, 'App\Entity\TickerChart[]', 'json' );
    }
}
