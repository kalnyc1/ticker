<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client;

class TickerController extends AbstractController
{
    /**
     * @Route( "/ticker/", schemes={"http"} )
     */
    public function ticker()
    {
        return $this->render('ticker.html.twig', [
        ]);
    }

    /**
     * @Route( "/tickerData/",
     *  methods={ "POST" } )
     *
     * @param  Request         $request [description]
     * @param  LoggerInterface $logger  [description]
     * @return [type]                   [description]
     */
    public function tickerData(
        Request $request,
        LoggerInterface $logger
    ) {
        // Get POST variables - Decode the request data
        $reqData = json_decode( $request->getContent(), true );

        // Validate keys
        if ( !array_key_exists( 'symbol', $reqData ) ) {
            throw new Exception("Invalid request.", 400);
        }

        // Set values
        $reqSymbol = $reqData['symbol'];

        // Validate
        if ( empty( $reqSymbol ) ) {
            throw new Exception("Invalid request.", 400);
        }

        try {
            // Create endpoint
            $ep = 'stock/' . $reqSymbol . '/batch?types=quote,chart&range=1d&chartInterval=1';

            $client = new Client( [
                //'debug' => true,
                'base_uri' => 'https://api.iextrading.com/1.0/'
            ] );

            $clientResp = $client->request( 'GET', $ep );
            $logger->debug( "STATUS: " . $clientResp->getStatusCode() );

            $responseBody = $clientResp->getBody()->getContents();
            $responseData = json_decode( (string)$responseBody, true );

            // Return JSON response
            return $this->json( [
                'companyName' => $responseData['quote']['companyName'],
                'primaryExchange' => $responseData['quote']['primaryExchange'],
                'sector' => $responseData['quote']['sector'],
                'previousClose' => $responseData['quote']['previousClose'],
                'openTime'  => $responseData['quote']['openTime'],
                'open' => $responseData['quote']['open'],
                'latestPrice' => $responseData['quote']['latestPrice'],
                'change' => $responseData['quote']['change'],
                'latestUpdate' => $responseData['quote']['latestUpdate'],
                'high' => $responseData['quote']['high'],
                'low' => $responseData['quote']['low'],
                'close' => $responseData['quote']['close'],
                'closeTime' => $responseData['quote']['closeTime'],
                'extendedPrice' => $responseData['quote']['extendedPrice'],
                'extendedPriceTime' => $responseData['quote']['extendedPriceTime'],
                'week52Low' => $responseData['quote']['week52Low'],
                'week52High' => $responseData['quote']['week52High'],
                'chart' => $responseData['chart']
            ], 200 );
        }
        catch ( Exception $ex ) {
            // Return JSON response
            return $this->json( [
                'error' => $ex->getMessage()
            ], 500 );
        }
    }

    /**
     * @Route( "/tickerChart/",
     *  methods={ "POST" } )
     *
     * @param  Request         $request [description]
     * @param  LoggerInterface $logger  [description]
     * @return [type]                   [description]
     */
    public function tickerChart(
        Request $request,
        LoggerInterface $logger
    ) {
        // Get POST variables - Decode the request data
        $reqData = json_decode( $request->getContent(), true );

        // Validate keys
        if ( !array_key_exists( 'symbol', $reqData ) ) {
            throw new Exception("Invalid request.", 400);
        }

        // Set values
        $reqSymbol = $reqData['symbol'];
        $reqDate = $reqData['date'];

        // Validate
        if ( empty( $reqSymbol ) || empty( $reqDate ) ) {
            throw new Exception("Invalid request.", 400);
        }

        try {
            // Create endpoint
            $ep = 'stock/' . $reqSymbol . '/chart/date/' . $reqDate . '?chartInterval=1';

            $client = new Client( [
                //'debug' => true,
                'base_uri' => 'https://api.iextrading.com/1.0/'
            ] );

            $clientResp = $client->request( 'GET', $ep );
            $logger->debug( "STATUS: " . $clientResp->getStatusCode() );

            $responseBody = $clientResp->getBody()->getContents();
            $responseData = json_decode( (string)$responseBody, true );

            //$logger->debug( "RESPONSE-DATA: " . print_r( $responseData, true ) );

            $chartData = [];

            // Only the data we need using a closure
            array_walk( $responseData, function ( $item, $key ) use ( &$chartData, $logger ) {
                //$logger->debug( "RESPONSE-DATA-ENTRY: " . $key . " => " . print_r( $item, true ) );

                if ( array_key_exists( 'close', $item ) ) {
                    $chartData[] = [
                        'label' => $item['label'],
                        'close' => $item['close']
                    ];
                }
            } );

            //$logger->debug( "CHART-DATA: " . print_r( $chartData , true ) );

            // Return JSON response
            return $this->json( [
                'chartData' => $chartData
            ], 200 );
        }
        catch ( Exception $ex ) {
            // Return JSON response
            return $this->json( [
                'error' => $ex->getMessage()
            ], 500 );
        }
    }

}
