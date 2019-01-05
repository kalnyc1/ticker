<?php
declare(strict_types = 1);

namespace App\Repository;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use App\Entity\TickerData;

class TickerDataRepositoryTest extends TestCase
{
    /**
     * 
     */
    public function testGetTickerDataReturnNull()
    {
        // Create a mock and queue one response.
        $mockHandler = new MockHandler( 
            [
                new Response( 500, [] )
            ] );

        $handlerStack = HandlerStack::create( $mockHandler );

        // Create a client
        $client = new Client( [
            'handler' => $handlerStack
        ] );
        
        $symbol = 'AAPL';
        
        // Create mock LoggerInterface
        $mockLogger = $this->getMockBuilder( LoggerInterface::class )
            ->disableOriginalConstructor()
            /*->setMethods( [
                'emergency',
                'alert',
                'critical',
                'error',
                'warning',
                'notice',
                'info',
                'debug',
                'log'
            ] )*/
            ->getMock();
        //$mockLogger->expects( $this->any() )->method( 'debug' );
            
        // Create mock TickerDataRepository
        $mockTickerDataRepo = $this->getMockBuilder( TickerDataRepository::class )
            ->setConstructorArgs( [$mockLogger] )
            //->setMethods( ['getTickerData'] )
            ->getMock();

        //$mockTickerDataRepo->m_logger = $mockLogger;
            
        // Expect getTickerData to return null on 500 error
        $mockTickerDataRepo->expects( $this->once() )
            ->method( 'getTickerData' )
            ->willReturn( null );

        // Make the call
        $mockTickerDataRepo->getTickerData( $client, $symbol );
    }
    
    /**
     * 
     */
    public function testGetTickerDataReturnSuccess()
    {
        // Create a mock and queue one response.
        $mockHandler = new MockHandler(
            [
                new Response( 200,
                    ['Content-Length' => 30 ],
                    '{ "companyName":"Google Inc."}' )
            ] );
        
        $handlerStack = HandlerStack::create( $mockHandler );
        
        // Create a client
        $client = new Client( [
            'handler' => $handlerStack
        ] );
        
        $symbol = 'AAPL';
        
        // Create mock LoggerInterface
        $mockLogger = $this->getMockBuilder( LoggerInterface::class )
            ->disableOriginalConstructor()
            /*->setMethods( [
             'emergency',
             'alert',
             'critical',
             'error',
             'warning',
             'notice',
             'info',
             'debug',
             'log'
             ] )*/
            ->getMock();
        //$mockLogger->expects( $this->any() )->method( 'debug' );
        
        // Create mock TickerDataRepository
        $mockTickerDataRepo = $this->getMockBuilder( TickerDataRepository::class )
            ->setConstructorArgs( [$mockLogger] )
            //->setMethods( ['getTickerData'] )
            ->getMock();

        // Create mock TickerData
        $mockTickerData = $this->getMockBuilder( TickerData::class )
            ->disableOriginalConstructor()
            ->getMock();
            
        // Expect getTickerData to return null on 500 error
        $mockTickerDataRepo->expects( $this->once() )
            ->method( 'getTickerData' )
            ->willReturn( $mockTickerData );
        
        // Make the call
        $mockTickerDataRepo->getTickerData( $client, $symbol );
    }
}
