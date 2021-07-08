<?php
    if (!function_exists('kirim_wa')) {
        function kirim_wa($no_hp='', $pesan='', $type='text') {
            $curl = curl_init();

            $data = array(
                'nohp' => $no_hp,
                'pesan' => $pesan,
                'tipe'  => $type
            );

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apibot.magelangkab.go.id/Api/wa/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'service: pkk',
                'token: aa631d76111cf6d48cc3ec8e52b331de',
                'Content-Type: application/json',
                'Cookie: ci_session=qckffegauo360hcd4qa7drt133uqoevk'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return $response;
        }
    }
?>