<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
class DnController extends Controller
{
    public function checkDomainAvailability($domain)
    {
        $apiKey = env('DOMAIN_API_KEY');
        $url = "https://domain-availability.whoisxmlapi.com/api/v1?apiKey=$apiKey&domainName=$domain";        
        $client = new Client();
        try {
            $response = $client->request('GET', $url);
            $data = json_decode($response->getBody(), true);
            $domainAvailable = $data['DomainInfo']['domainAvailability'] == 'AVAILABLE';

            return response()->json([
                'domain' => $domain,
                'available' => $domainAvailable
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Impossible de vérifier la disponibilité du domaine.']);
        }
    }
}
