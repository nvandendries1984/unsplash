<?php namespace Nielsvandendries\Unsplash\Components;

use Cms\Classes\ComponentBase;
use GuzzleHttp\Client;

class Wallpaper extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Unsplash Wallpaper',
            'description' => 'Retrieves an image from Unsplash using API'
        ];
    }

    public function defineProperties()
    {
        return [
            'unsplashAccessKey' => [
                'title' => 'Unsplash Access Key',
                'description' => 'Voer je Unsplash Access Key in',
                'default' => '',
                'type' => 'string',
            ],
            'unsplashSecretKey' => [
                'title' => 'Unsplash Secret Key',
                'description' => 'Voer je Unsplash Secret Key in',
                'default' => '',
                'type' => 'string',
            ],
        ];
    }    

    public function onRun()
    {
        // Haal de Unsplash API Access Key en Secret Key op uit de componentinstellingen
        $accessKey = $this->property('unsplashAccessKey');
        $secretKey = $this->property('unsplashSecretKey');

        // Stel de basis-URL in voor de Unsplash API
        $apiUrl = 'https://api.unsplash.com/photos/random';

        // Maak een HTTP-client
        $client = new Client();

        // Genereer een OAuth2-bearer token met je Access Key en Secret Key
        $response = $client->post('https://unsplash.com/oauth/token', [
            'form_params' => [
                'client_id' => $accessKey,
                'client_secret' => $secretKey,
                'grant_type' => 'client_credentials',
            ]
        ]);

        $tokenData = json_decode($response->getBody(), true);
        $accessToken = $tokenData['access_token'];

        // Doe een GET-verzoek naar de API met het verkregen bearer token
        $response = $client->get($apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
            'query' => [
                'count' => 1, // Aantal wallpapers dat je wilt ophalen
            ]
        ]);

        // Verwerk de API-respons
        $data = json_decode($response->getBody(), true);

        // Nu kun je de gegevens gebruiken zoals je wilt
        // $data bevat informatie over de opgehaalde wallpaper, zoals URL en metadata

        // Stel de gegevens in zodat ze beschikbaar zijn in de component's view
        $this->page['wallpaperData'] = $data;
    }
}
