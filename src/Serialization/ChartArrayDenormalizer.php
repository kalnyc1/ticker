<?php
declare(strict_types = 1);

namespace App\Serialization;

use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;

class ChartArrayDenormalizer extends ArrayDenormalizer
{
    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Serializer\Normalizer\ArrayDenormalizer::denormalize()
     */
    public function denormalize( $data, $class, $format = null, array $context = array() )
    {
        $modifiedData = [];
        
        // Skip items with no close value
        array_walk( $data, function ( $item, $key ) use ( &$modifiedData ) {
            if ( array_key_exists( 'close', $item ) ) {
                $modifiedData[] = $item;
            }
        } );        
        
        return parent::denormalize( $modifiedData, $class, $format, $context );
    }
}
