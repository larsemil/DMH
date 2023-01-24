
<?php
//     API för att kontrollera medlemskap i Berghems Vänner:
//     API-Nyckel för Berghems vänner 
//     (F-ID: F080246-0)
//     zuZqeVgYGU/SY+JRMVlikQcaV+KHAksf
    
//     Anropsadress: https://ebas.sverok.se/apis/confirm_membership.json
//     Inkludera valfritt antal sökkriterier för att bekräfta att minst ett matchande medlemskap finns.
//     Mall för JSON anrop
    
//     {
//         "request" : {
//             "action" : "confirm_membership",
//             "association_number" : "Ert F-nummer",
//             "api_key" : "Er API-nyckel",
//             "year_id" : YYYY,
//             "firstname": "",
//             "lastname": "",
//             "socialsecuritynumber": "YYYYMMDDXXXX",
//             "email": "",
//             "phone1": "",
//             "member_nick": null                                       
//             }
//     }
    
//     Returnerar sant/falskt för om ett medlemskap kan hittas med sökkriterierna.
// 197503149317 196506167235
function check_membership(string $socialsecuritynumber, string $year)
{
    $url = "https://ebas.sverok.se/apis/confirm_membership.json";
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $headers = array(
       "Accept: application/json",
       "Content-Type: application/json",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
    $data = <<<DATA
    {
    							"request":
    							{
    								"action" : "confirm_membership",
    								"association_number" : "F080246-0",
    								"api_key" : "zuZqeVgYGU/SY+JRMVlikQcaV+KHAksf",
    								"year_id" : "$year",
    								"socialsecuritynumber": "$socialsecuritynumber"
    							}                                                
    						}
    DATA;
    
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    
    $resp = curl_exec($curl);
    curl_close($curl);
    
     //echo $resp;
//     echo "<br />1<br />";
    $obj = json_decode($resp);
     //print_r($obj);
    // echo "<br />2<br />";
    if (!isset($obj->response) || is_null($obj->response)) return false;
    $response = $obj->response;
    //echo "<br />3<br />";
    //echo "Resp: " . strlen($response->member_found);
    if (!isset($response->member_found) || is_null($response->member_found) || strlen($response->member_found)==0 ) {
        echo "Empty";
        return false;
        
    }
    $member_found = $response->member_found;
    
    return $member_found;
}


?>