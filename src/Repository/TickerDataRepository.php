<?php
declare(strict_types = 1);

namespace App\Repository;

use App\Entity\TickerData;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\{
    Serializer,
    Encoder\JsonEncoder,
    Normalizer\ObjectNormalizer
};
use GuzzleHttp;

class TickerDataRepository
{    
    /**
     * @var LoggerInterface
     */
    private $m_logger = null;
    
    /**
     * Constructor
     * @param LoggerInterface $logger
     */
    public function __construct( LoggerInterface $logger )
    {
        $this->m_logger = $logger;
    }
    
    /**
     * Get the symbol ticker data.
     * @param string $symbol
     * @return TickerData
     */
    public function getTickerData( GuzzleHttp\Client $client, string $symbol ): ?TickerData
    {
        // Create endpoint
        //$endPoint = 'stock/' . $symbol . '/batch?types=quote,chart&range=1d&chartInterval=1';
        $endPoint = 'stock/' . $symbol . '/quote';

        $clientResp = $client->request( 'GET', $endPoint );
        $this->m_logger->debug( "STATUS: " . $clientResp->getStatusCode() );
        
        if ( $clientResp->getStatusCode() != 200 ) {
            return null;
        }

        $responseBody = $clientResp->getBody()->getContents();
        //$responseData = json_decode( (string)$responseBody, true );
        
        // We could use json_decode to do this, but
        // lets have some fun and use deserialization.
        //$responseData = json_decode( (string)$responseBody, true );
        $encoder = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $serializer = new Serializer( $normalizer, $encoder );
        
        return $serializer->deserialize( $responseBody, TickerData::class, 'json' );
    }
}
