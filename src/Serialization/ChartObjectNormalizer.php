<?php
declare(strict_types = 1);

namespace App\Serialization;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ChartObjectNormalizer extends ObjectNormalizer
{
    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer::denormalize()
     */
    public function denormalize( $data, $class, $format = null, array $context = array() )
    {
        
        if ( !array_key_exists( 'close', $data ) ) {
            $data['close'] = null;
        }

        return parent::denormalize( $data, $class, $format, $context );
    }
  
}
