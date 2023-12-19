<?php

class ApiConsumer
{
    private function api($endpoint, $method = 'GET', $post_fields = [])
    {

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://restcountries.com/v3.1/$endpoint",
            CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => [
                "Accept: */*"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return json_decode($response, true);
        }
    }

    public function get_all_countries(){
        // buscar todos os dados
        $results = $this->api('all');
        $countries = [];
        foreach($results as $result){
            $countries[] = $result['name']['common'];
        }
        sort($countries); // ordena tudo por ordem alfabetica
        return $countries;
    }

    public function get_country($country_name){
        // buscar um País especifico.
        return $this->api("name/$country_name");
    }
}
