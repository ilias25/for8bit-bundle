<?php

namespace Ilias25\For8BitBundle\Services;

use Ilias25\For8BitBundle\Entity\Location;
use Ilias25\For8BitBundle\Exception\UndefinedSettingException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class GoogleGeoService
{
    const API_URL = 'url';
    const API_KEY = 'key';


    protected $client;
    protected $settings;

    /**
     * GoogleGeoService constructor
     *
     * @param Client $client
     * @param array $settings
     */
    public function __construct(Client $client, array $settings) {
        $this->client   = $client;
        $this->settings = $settings;
    }

    /**
     * Get setting by name
     *
     * @param string $name
     * @return mixed
     */
    protected function getSetting($name)
    {
        if (!isset($this->settings[$name])) {
            throw new UndefinedSettingException($name);
        }
        return $this->settings[$name];
    }

    /**
     * Prepare params
     *
     * @param array $params
     * @return array
     */
    protected function prepareParams(array $params)
    {
        $params['key'] = $this->getSetting(self::API_KEY);

        return [RequestOptions::QUERY => $params];
    }

    /**
     * Send request
     *
     * @param array  $params
     *
     * @return array
     */
    protected function sendRequest(array $params = [])
    {
        $response = $this->client->post($this->getSetting(self::API_URL), $this->prepareParams($params));

        $return = $this->processResponse($response);

        return $return;
    }

    /**
     * Process response
     *
     * @param ResponseInterface $result
     * @return array
     * @throws \Exception
     */
    protected function processResponse(ResponseInterface $result)
    {
        $rawBody = $result->getBody();
        $response = json_decode($rawBody, true);

        if(is_null($response) || empty($response['status'])) {
            if (json_last_error() !== JSON_ERROR_NONE) {
                // decode error
                throw new \Exception(json_last_error_msg(), json_last_error());
            }

            throw new \Exception('Incorrect response');
        } elseif ($response['status'] !== 'OK') {
            // status not OK
            $errorMessage = 'Error occurred while your request';
            if (isset($response['error_message'])) {
                // has Error
                $errorMessage = $response['error_message'];
            }

            throw new \Exception($errorMessage);
        }

        return $response;
    }

    /**
     * Returns location collection for the query
     * See https://developers.google.com/places/web-service/search#TextSearchRequests
     *
     * @param string $text
     * @return Location[]
     */
    public function getLocationsByPlace($text)
    {
        $response = $this->sendRequest(['query' => urlencode($text)]);

        $locations = [];
        foreach($response['results'] as $locationData) {
            $location = new Location();
            $location
                ->setName($locationData['name'])
                ->setLatitude($locationData['geometry']['location']['lat'])
                ->setLongitude($locationData['geometry']['location']['lng']);

            $locations[] = $location;
        }

        return $locations;
    }
}