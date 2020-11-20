<?php

namespace App\Model;

use Symfony\Component\HttpClient\HttpClient;

class AssembleeApiManager
{
    private $urlBase;
    public function __construct()
    {
        $this->urlBase = 'http://www.assemblee-nationale.fr/dyn/opendata/list-publication/publication_';
    }

    public function getAll(): array
    {
        $client = HttpClient::create();
        $laws = [];

        for ($i = 0; $i < 2; $i++) {
            $url = $this->urlBase . "j-$i";
            $response = $client->request('GET', $url);
            $statusCode = $response->getStatusCode();
// get Response status code 200

            if ($statusCode === 200) {
                $content = $response->getContent();
// get the response in JSON format

                // now we create array
                $content2 = str_replace([' ', CHR(13), CHR(10)], [';',';',';'], $content);
                $bulkLaws = explode(";", $content2);
// and search inside if we have a proposition of a new law
                foreach ($bulkLaws as $value) {
                    if (strpos($value, "PIONANR5L15") && strpos($value, ".pdf")) {
                        array_push($laws, $value);
                    }
                }
            }
            // we have to take time, it's from oficials work
            sleep(2);
// wait 2 seconds between each call
        }
        // at this point, we have the laws url in an array, now, we need date and main title
        $lawsToReturn = [];
        $counter = count($laws);
        for ($i = 0; $i < $counter; $i++) {
            $lawsToReturn[$i]['url'] = $laws[$i];
            $path = str_replace('.pdf', '.json', $laws[$i]);
            $response = $client->request('GET', $path);
            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {
                $content = $response->getContent();
                $content = $response->toArray();
                $lawsToReturn[$i]['dateDepot'] = substr($content['cycleDeVie']['chrono']['dateDepot'], 0, 10);
                $date = date_create($lawsToReturn[$i]['dateDepot']);
                date_add($date, date_interval_create_from_date_string('30 days'));
                $lawsToReturn[$i]['dateVote'] = date_format($date, 'Y-m-d');
                $lawsToReturn[$i]['titrePrincipal'] = $content['titres']['titrePrincipal'];
            }
        }
        return $lawsToReturn;
    }

    public function getOne(string $url): array
    {
        $lawToReturn['url'] = $url;
        $path = str_replace('.pdf', '.json', $url);
        $client = HttpClient::create();
        $response = $client->request('GET', $path);
        $statusCode = $response->getStatusCode();
// get Response status code 200

        if ($statusCode === 200) {
            $content = $response->getContent();
            $content = $response->toArray();
            $lawToReturn['dateDepot'] = substr($content['cycleDeVie']['chrono']['dateDepot'], 0, 10);
            $date = date_create($lawToReturn['dateDepot']);
            date_add($date, date_interval_create_from_date_string('30 days'));
            $lawToReturn['dateVote'] = date_format($date, 'Y-m-d');
            $lawToReturn['titrePrincipal'] = $content['titres']['titrePrincipal'];
        }
        return $lawToReturn;
    }

    public function getHazard(): array
    {
        $client = HttpClient::create();
        $laws = [];
        $i = 0;
        while ([] == $laws) {
            $url = $this->urlBase . "j-$i";
            $response = $client->request('GET', $url);
            $statusCode = $response->getStatusCode();
        // get Response status code 200

            if ($statusCode === 200) {
                $content = $response->getContent();
// get the response in JSON format

                // now we create array
                $content2 = str_replace([' ', CHR(13), CHR(10)], [';',';',';'], $content);
                $bulkLaws = explode(";", $content2);
// and search inside if we have a proposition of a new law
                foreach ($bulkLaws as $value) {
                    if (strpos($value, "PIONANR5L15") && strpos($value, ".pdf")) {
                        array_push($laws, $value);
                    }
                }
            }
            if ([] == $laws) {
// we have to take time, it's from oficials work
                sleep(2);
// wait 2 seconds between each call
            }
        }
        return $this->getOne($laws[0]);
    }
}
