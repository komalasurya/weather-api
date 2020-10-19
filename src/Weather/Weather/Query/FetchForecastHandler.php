<?php
declare(strict_types=1);

namespace Weather\Weather\Query;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Weather\Weather\Value\Constant;
use function Pandawa\Reactive\map;
use function Pandawa\Reactive\of;

/**
 * Class FetchForecastHandler
 * @author Komala Surya <komala.surya.w@gmail.com>
 */
final class FetchForecastHandler
{
    private const API_PATH = 'https://api.openweathermap.org/data/2.5/onecall?appid=%s&lat=%s&lon=%s&units=metric&exclude=daily,minutely';

    /** @var Client */
    private $client;

    private $results;

    /**
     * FetchForecastHandler constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function handle(FetchForecast $message)
    {
        try {
            of($message)->pipe(
                map(function (FetchForecast $message) {
                    $apiKey = env(Constant::API_KEY);
                    $uri = sprintf(self::API_PATH,
                        $apiKey, $message->getLat(), $message->getLon());
                    return $this->client->get($uri);
                })
            )->subscribe(function ($results) {
                $this->results = $results;
            });
        } catch (ClientException $exception) {
            $body = json_decode((string) $exception->getResponse()->getBody(), true);
            abort($body['cod'], $body['message']);
        }

        $body = (string) $this->results->getBody();

        return json_decode($body, true);
    }
}