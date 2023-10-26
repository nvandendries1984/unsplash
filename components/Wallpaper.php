<?php namespace NielsVanDenDries\Unsplash\Components;

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
                'description' => 'Enter your Unsplash Access Key',
                'default' => '',
                'type' => 'string',
            ],
            'unsplashSecretKey' => [
                'title' => 'Unsplash Secret Key',
                'description' => 'Enter your Unsplash Secret Key',
                'default' => '',
                'type' => 'string',
            ],
        ];
    }    

    public function onRun()
    {
        $accessKey = $this->property('unsplashAccessKey');
        $secretKey = $this->property('unsplashSecretKey');

        $apiUrl = 'https://api.unsplash.com/photos/random';

        $client = new Client();

        $response = $client->post('https://unsplash.com/oauth/token', [
            'form_params' => [
                'client_id' => $accessKey,
                'client_secret' => $secretKey,
                'grant_type' => 'client_credentials',
            ]
        ]);

        $tokenData = json_decode($response->getBody(), true);
        $accessToken = $tokenData['access_token'];

        $response = $client->get($apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
            'query' => [
                'count' => 1,
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        $this->page['wallpaperData'] = $data;
    }
}
