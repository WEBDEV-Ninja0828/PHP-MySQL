<?php
include "/var/www/sublimerevenue.com/API/config.php";

//get aff id from direct-offer
$tracker = $_GET['idev_id'];
if (isset($_GET['idev_tid1'])) 
{ 
$tid11 = $_GET['idev_tid1'];
} 
if (isset($_GET['idev_tid2'])) 
{ 
$tid22 = $_GET['idev_tid2'];
} 
if (isset($_GET['idev_tid3'])) 
{ 
$tid33 = $_GET['idev_tid3'];
} 
if (isset($_GET['idev_tid4'])) 
{ 
$tid44 = $_GET['idev_tid4'];
} 
$delitel = 'RkwuK6';
if (isset($_GET['set'])) { 
$set = $_GET['set'];
}
if (isset($_GET['link'])) { 
$link = $_GET['link'];
}
$ip = $_SERVER['REMOTE_ADDR'];

if (filter_var($ip, FILTER_VALIDATE_IP)) {
    if (filter_var($ip, FILTER_VALIDATE_IP)) {
        function Dot2LongIP($IPaddr) 
        {
            if ($IPaddr == "") {
                return 0;
            }
            $ips = explode(".", $IPaddr);
            return $ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256;
        }
        $ipno = Dot2LongIP($ip);
        $ipquery = "SELECT country_code FROM idevaff_ip2location WHERE " . $ipno . " <= ip_to LIMIT 1";
    } else {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            function Dot2LongIPipv6($ip)
            {
                $int = inet_pton($ip);
                $bits = 15;
                for ($ipv6long = 0; 0 <= $bits; $bits--) {
                    $bin = sprintf("%08b", ord($int[$bits]));
                    if ($ipv6long) {
                        $ipv6long = $bin . $ipv6long;
                    } else {
                        $ipv6long = $bin;
                    }
                }
                $ipv6long = gmp_strval(gmp_init($ipv6long, 2), 10);
                return $ipv6long;
            }
            $ipno = Dot2LongIPipv6($ip);
            $ipquery = "SELECT country_code FROM idevaff_ip2location_ipv6 WHERE " . $ipno . " <= ip_to LIMIT 1";
        }
    }
    $ipresult = $db->query($ipquery);
    if (0 < $ipresult->rowCount()) {
        $country_check = $ipresult->fetch();
        $country = $country_check["country_code"];
    }
} else {
    $country = 'XX';
}

$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
//mobile traffic start

    session_start();

    function checkUrl($url, $urls){
        if(count($_SESSION['visited']) == count($urls)){
               $_SESSION['visited'] = Array();
        }
        if(in_array($url, $_SESSION['visited'])){
             $url = $urls[array_rand($urls)];
             checkUrl($url, $urls);
        }
        else{
             $_SESSION['visited'][] = $url;
             header("Location: $url");
        }
    }
// geo target first with geo direct offer direct-offers or simply direct-offers if offers are good for this geo
if ( $country == "LV" && $link == "95" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1105&aff_id=10787&pid=70549&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=direct-offer&mbbr=1&pof=1&aof=1" // LV-CleoLUX-Mobile (ID: 1105)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "EE" && $link == "95" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1103&aff_id=10787&pid=70547&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=direct-offer&mbbr=1&pof=1&aof=1" // EE-CleoLUX-Mobile (ID: 1103)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "CZ" && $link == "95" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1095&aff_id=10787&pid=69347&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=direct-offer&mbbr=1&pof=1&aof=1" // CZ-CleoLUX-Mobile (ID: 1095)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "IT" && $link == "95" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1094&aff_id=10787&pid=70949&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=direct-offer&mbbr=1&pof=1&aof=1", // IT-CleoLUX-Mobile (ID: 1094)
        "https://gltrak.com/aff_c2.php?offer_id=1094&aff_id=10787&pid=69350&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=direct-offer&mbbr=1&pof=1&aof=1" // IT-CleoLUX-Mobile (ID: 1094)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "HR" && $link == "95" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1093&aff_id=10787&pid=69348&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=direct-offer&mbbr=1&pof=1&aof=1" // HR-CleoLUX-Mobile (ID: 1093)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "HU" && $link == "95" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1092&aff_id=10787&pid=69349&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=direct-offer&mbbr=1&pof=1&aof=1" // HU-CleoLUX-Mobile (ID: 1092)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SI" && $link == "95" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1083&aff_id=10787&pid=66684&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=direct-offer&mbbr=1&pof=1&aof=1" // SI-CleoLUX-Mobile (ID: 1083)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SK" && $link == "95" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1081&aff_id=10787&pid=66678&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=direct-offer&mbbr=1&pof=1&aof=1" // SK-CleoLUX-Mobile (ID: 1081)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "LV" && $link == "278" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1105&aff_id=10787&pid=70541&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=direct-offer&mbbr=1&pof=1&aof=1" // LV-CleoLUX-Mobile (ID: 1105)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "EE" && $link == "278" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1103&aff_id=10787&pid=70545&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=direct-offer&mbbr=1&pof=1&aof=1" // EE-CleoLUX-Mobile (ID: 1103)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "CZ" && $link == "278" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1095&aff_id=10787&pid=69340&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=direct-offer&mbbr=1&pof=1&aof=1" // CZ-CleoLUX-Mobile (ID: 1095)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "IT" && $link == "278" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1094&aff_id=10787&pid=70948&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile3&creative=direct-offer&mbbr=1&pof=1&aof=1", // IT-CleoLUX-Mobile (ID: 1094)
        "https://gltrak.com/aff_c2.php?offer_id=1094&aff_id=10787&pid=69343&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile4&creative=direct-offer&mbbr=1&pof=1&aof=1" // IT-CleoLUX-Mobile (ID: 1094)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "HR" && $link == "278" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1093&aff_id=10787&pid=69341&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=direct-offer&mbbr=1&pof=1&aof=1" // HR-CleoLUX-Mobile (ID: 1093)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "HU" && $link == "278" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1092&aff_id=10787&pid=69342&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=direct-offer&mbbr=1&pof=1&aof=1" // HU-CleoLUX-Mobile (ID: 1092)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SI" && $link == "278" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1083&aff_id=10787&pid=66676&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=direct-offer&mbbr=1&pof=1&aof=1" // SI-CleoLUX-Mobile (ID: 1083)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SK" && $link == "278" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1081&aff_id=10787&pid=66686&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=direct-offer&mbbr=1&pof=1&aof=1" // SK-CleoLUX-Mobile (ID: 1081)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} else {
//fallback to direct-offers after geo target
    $urls = array(
        "http://ck.gl2021.info/53030?subaffiliate_id=$tracker&session_id=$country$delitel$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id", // Glize Nutra
        "https://dtrk.slimcdn.com/directclick/?pid=r3osD70AeZ7IQyPv0pjPCaK0Vjg1&wsid=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&subid=$tracker", // SlimSpots mainstream direct-offer
        "https://newgamesapp.net/?id=45268&clickid=sublimerevenue-mainstream&clickid2=direct-offer&clickid3=$tracker&clickid4=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id", // BitterStrawberry mainstream direct-offer
        "https://1d5df208093.traffic-c.com/?p=5221&media_type=mainstream&pi=$tracker&click_id=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id" // TrafficCompany mainstream direct-offer
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
}
// mobile traffic end
} else {
// desktop traffic start

    session_start();

    function checkUrl($url, $urls){
        if(count($_SESSION['visited']) == count($urls)){
               $_SESSION['visited'] = Array();
        }
        if(in_array($url, $_SESSION['visited'])){
             $url = $urls[array_rand($urls)];
             checkUrl($url, $urls);
        }
        else{
             $_SESSION['visited'][] = $url;
             header("Location: $url");
        }
    }
//geo target first with geo direct offer direct-offers or simply direct-offers if offers are good for this geo
if ( $country == "LV" && $link == "95" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1104&aff_id=10787&pid=70548&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // LV-CleoLUX-Desktop (ID: 1104)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "EE" && $link == "95" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1102&aff_id=10787&pid=70546&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // EE-CleoLUX-Desktop (ID: 1102)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SI" && $link == "95" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1082&aff_id=10787&pid=66683&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // SI-CleoLUX-Desktop (ID: 1082)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SK" && $link == "95" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1080&aff_id=10787&pid=66677&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // SK-CleoLUX-Desktop (ID: 1080)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "HU" && $link == "95" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1079&aff_id=10787&pid=66338&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // HU-CleoLUX-Desktop (ID: 1079)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "CZ" && $link == "95" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1074&aff_id=10787&pid=66064&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // CZ-CleoLUX-Desktop (ID: 1074)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "IT" && $link == "95" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1073&aff_id=10787&pid=66066&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // IT-CleoLUX-Desktop (ID: 1073)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "HR" && $link == "95" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1072&aff_id=10787&pid=66065&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // HR-CleoLUX-Desktop (ID: 1072)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "LV" && $link == "278" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1104&aff_id=10787&pid=70540&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=direct-offer&mbbr=1&pof=1&aof=1" // LV-CleoLUX-Desktop (ID: 1104)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "EE" && $link == "278" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1102&aff_id=10787&pid=70544&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=direct-offer&mbbr=1&pof=1&aof=1" // EE-CleoLUX-Desktop (ID: 1102)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SI" && $link == "278" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1082&aff_id=10787&pid=66675&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=direct-offer&mbbr=1&pof=1&aof=1" // SI-CleoLUX-Desktop (ID: 1082)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SK" && $link == "278" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1080&aff_id=10787&pid=66685&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=direct-offer&mbbr=1&pof=1&aof=1" // SK-CleoLUX-Desktop (ID: 1080)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "HU" && $link == "278" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1079&aff_id=10787&pid=66340&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=direct-offer&mbbr=1&pof=1&aof=1" // HU-CleoLUX-Desktop (ID: 1079)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "CZ" && $link == "278" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1074&aff_id=10787&pid=65893&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=direct-offer&mbbr=1&pof=1&aof=1" // CZ-CleoLUX-Desktop (ID: 1074)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "IT" && $link == "278" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1073&aff_id=10787&pid=65895&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=direct-offer&mbbr=1&pof=1&aof=1" // IT-CleoLUX-Desktop (ID: 1073)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "HR" && $link == "278" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1072&aff_id=10787&pid=65894&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=direct-offer&mbbr=1&pof=1&aof=1" // HR-CleoLUX-Desktop (ID: 1072)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} else {
//fallback to direct-offers after geo target
    $urls = array(
        "http://ck.gl2021.info/53030?subaffiliate_id=$tracker&session_id=$country$delitel$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id", // Glize Nutra
        "http://ck.glzelnk.com/53653?subaffiliate_id=$tracker&session_id=$country$delitel$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id", // Glize Fitnessdirect-offer
        "https://dtrk.slimcdn.com/directclick/?pid=r3osD70AeZ7IQyPv0pjPCaK0Vjg1&wsid=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&subid=$tracker", // SlimSpots mainstream direct-offer
        "https://1d5df208093.traffic-c.com/?p=5221&media_type=mainstream&pi=$tracker&click_id=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id" // TrafficCompany mainstream direct-offer
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
}
// desktop traffic end
}
?>