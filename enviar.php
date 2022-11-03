<?php

if (isset($_POST['Number'])) {
    $numcel = $_POST['Number'];
    $tipo = $_POST['type'];
    $url = $_POST['url'];
    $utm_source = "";
    $utm_medium = "";
    $utm_campaign = "";

    list($utm_sourcev1, $utm_sourcev2) = explode('utm_source%3D', $url);
    list($utm_source, $utm_sourcev3) = explode('%26utm_medium', $utm_sourcev2);

    list($utm_mediumv1, $utm_medium2) = explode('utm_medium%3D', $url);
    list($utm_medium, $utm_medium3) = explode('%26utm_campaign', $utm_medium2);

    list($utm_campaignv1, $utm_campaign) = explode('utm_campaign%3D', $url);

    $urldirect = "https://pruebasetb.etb.com/2playfibra-amp/gracias-Duofibra.html/?utm_source=$utm_source&utm_medium=$utm_medium&utm_campaign=$utm_campaign";

    $url = "https://localhost:44352/api/ValidaLeads?type=" + $tipo + "&Number=" + $numcel + "&utm_source=" + $utm_source + "&utm_medium=" + $utm_medium + "&utm_campaign=" + $utm_campaign;


    $ch = curl_init();
    if (!$ch) {
        die("Couldn't initialize a cURL handle");
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: Application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xmldata);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $result = curl_exec($ch); // execute
    curl_close($ch);

    $result2 = strpos($result, "ok");
    if ($result2 === false) {
        echo json_encode('submit-error');
        exit;
    } else {
        $domain_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        header("Content-type: application/json");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Origin: " . str_replace('.', '-', 'infoetb.com') . ".cdn.ampproject.org");
        header("AMP-Access-Control-Allow-Source-Origin: " . $domain_url);
        header("Access-Control-Expose-Headers: AMP-Access-Control-Allow-Source-Origin");
        header("AMP-Redirect-To: $urldirect");
        header("Access-Control-Expose-Headers: AMP-Redirect-To, AMP-Access-Control-Allow-Source-Origin");
        echo json_encode('submit-success');
        exit;
    }
}
