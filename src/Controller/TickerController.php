<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Repository\TickerChartRepository;
use App\Repository\TickerDataRepository;
use Exception;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TickerController extends AbstractController
{

    /**
     *
     * @Route( "/ticker/", schemes={"http"} )
     */
    public function ticker()
    {
        return $this->render( 'ticker.html.twig', [] );
    }

    /**
     *
     * @Route( "/tickerData/", methods={ "POST" } )
     *
     * @param Request $request
     * @param LoggerInterface $logger
     * @throws Exception
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tickerData(
        Request $request,
        LoggerInterface $logger,
        TickerDataRepository $tickerDataRepo,
        TickerChartRepository $tickerChartRepo )
    {
        // Get POST variables - Decode the request data
        $reqData = json_decode( $request->getContent(), true );

        // Validate keys
        if ( ! array_key_exists( 'symbol', $reqData ) ) {
            throw new Exception( "Invalid request.", 400 );
        }

        // Set values
        $reqSymbol = $reqData['symbol'];

        // Validate
        if ( empty( $reqSymbol ) ) {
            throw new Exception( "Invalid request.", 400 );
        }

        try {
            $client = new Client( [
                // 'debug' => true,
                'base_uri' => 'https://api.iextrading.com/1.0/'
            ] );

            $tickerData = $tickerDataRepo->getTickerData( $client, $reqSymbol );
            if ( is_null( $tickerData ) ) {
                throw new Exception('Error getting ticker data.', 500 );
            }

            $tickerCharts = $tickerChartRepo->getTickerChart( $client, $reqSymbol, null );
            if ( is_null( $tickerCharts ) ) {
                throw new Exception('Error getting ticker chart.', 500 );
            }

            return $this->json(
                [
                    'data' => $tickerData,
                    'chart' => $tickerCharts
                ], 200 );
        }
        catch ( Exception $ex ) {
            // Return JSON response
            return $this->json( [
                'error' => $ex->getMessage()
            ], (int)$ex->getCode() ?: 500 );
        }
    }

    /**
     *
     * @Route( "/tickerChart/", methods={ "POST" } )
     *
     * @param Request $request
     * @param LoggerInterface $logger
     * @throws Exception
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tickerChart( Request $request, LoggerInterface $logger )
    {
        // Get POST variables - Decode the request data
        $reqData = json_decode( $request->getContent(), true );

        // Validate keys
        if ( ! array_key_exists( 'symbol', $reqData ) ) {
            throw new Exception( "Invalid request.", 400 );
        }

        // Set values
        $reqSymbol = $reqData['symbol'];
        $reqDate = $reqData['date'];

        // Validate
        if ( empty( $reqSymbol ) || empty( $reqDate ) ) {
            throw new Exception( "Invalid request.", 400 );
        }

        try {
            // Create endpoint
            $ep = 'stock/' . $reqSymbol . '/chart/date/' . $reqDate . '?chartInterval=1';

            $client = new Client( [
                // 'debug' => true,
                'base_uri' => 'https://api.iextrading.com/1.0/'
            ] );

            $clientResp = $client->request( 'GET', $ep );
            $logger->debug( "STATUS: " . $clientResp->getStatusCode() );

            $responseBody = $clientResp->getBody()->getContents();
            $responseData = json_decode( (string)$responseBody, true );

            // $logger->debug( "RESPONSE-DATA: " . print_r( $responseData, true ) );
            $chartData = [];

            // Only the data we need using a closure
            array_walk( $responseData, function ( $item, $key ) use ( &$chartData, $logger ) {
                // $logger->debug( "RESPONSE-DATA-ENTRY: " . $key . " => " . print_r( $item, true ) );

                if ( array_key_exists( 'close', $item ) ) {
                    $chartData[] = [
                        'label' => $item['label'],
                        'close' => $item['close']
                    ];
                }
            } );

            // $logger->debug( "CHART-DATA: " . print_r( $chartData , true ) );

            // Return JSON response
            return $this->json( [
                'chartData' => $chartData
            ], 200 );
        }
        catch ( Exception $ex ) {
            // Return JSON response
            return $this->json( [
                'error' => $ex->getMessage()
            ], (int)$ex->getCode() ?: 500 );
        }
    }
}
