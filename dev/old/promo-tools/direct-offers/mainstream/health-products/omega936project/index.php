<?php
include "/var/www/sublimerevenue.com/API/config.php";

//get aff id from smartlink
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
// geo target first with geo direct offer smartlinks or simply smartlinks if offers are good for this geo
if ( $country == "BG" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1259&aff_id=10787&pid=83066&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=direct-offer&mbbr=1&pof=1&aof=1" // BG-Omega936Project-Mobile (ID: 1259) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "BG" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1259&aff_id=10787&pid=83069&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=direct-offer&mbbr=1&pof=1&aof=1" // BG-Omega936Project-Mobile (ID: 1259) Pre-landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "GR" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1141&aff_id=10787&pid=73178&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=direct-offer&mbbr=1&pof=1&aof=1" // GR-Omega936Project-Mobile (ID: 1141) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "GR" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1141&aff_id=10787&pid=73230&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=direct-offer&mbbr=1&pof=1&aof=1" // GR-Omega936Project-Mobile (ID: 1141) Pre-landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SI" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1139&aff_id=10787&pid=73177&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=direct-offer&mbbr=1&pof=1&aof=1" // SI-Omega936Project-Mobile (ID: 1139) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SI" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1139&aff_id=10787&pid=73181&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=direct-offer&mbbr=1&pof=1&aof=1" // SI-Omega936Project-Mobile (ID: 1139) Pre-landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "RO" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1124&aff_id=10787&pid=71730&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=direct-offer&mbbr=1&pof=1&aof=1" // RO-Omega936Project-Mobile (ID: 1124) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "RO" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1124&aff_id=10787&pid=73060&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=direct-offer&mbbr=1&pof=1&aof=1" // RO-Omega936Project-Mobile (ID: 1124) Pre-landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "CZ" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1121&aff_id=10787&pid=72656&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=direct-offer&mbbr=1&pof=1&aof=1" // CZ-Omega936Project-Mobila (ID: 1121) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "CZ" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1121&aff_id=10787&pid=72659&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=direct-offer&mbbr=1&pof=1&aof=1" // CZ-Omega936Project-Mobila (ID: 1121) Pre-landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "PL" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1119&aff_id=10787&pid=72654&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=direct-offer&mbbr=1&pof=1&aof=1" // PL-Omega936Project-Mobile (ID: 1119) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "PL" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1119&aff_id=10787&pid=72662&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=direct-offer&mbbr=1&pof=1&aof=1" // PL-Omega936Project-Mobile (ID: 1119) Pre-landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SK" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1117&aff_id=10787&pid=72651&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=direct-offer&mbbr=1&pof=1&aof=1" // SK-Omega936Project-Mobile (ID: 1117) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SK" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1117&aff_id=10787&pid=72652&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=direct-offer&mbbr=1&pof=1&aof=1" // SK-Omega936Project-Mobile (ID: 1117) Pre-landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "IT" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1116&aff_id=10787&pid=72646&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=direct-offer&mbbr=1&pof=1&aof=1" // IT-Omega936Project-Mobile (ID: 1116) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "IT" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1116&aff_id=10787&pid=72650&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=direct-offer&mbbr=1&pof=1&aof=1" // IT-Omega936Project-Mobile (ID: 1116) Pre-landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "HR" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1078&aff_id=10787&pid=66296&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=direct-offer&mbbr=1&pof=1&aof=1" // HR-Omega936Project-Mobile (ID: 1078) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "HR" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1078&aff_id=10787&pid=66337&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=direct-offer&mbbr=1&pof=1&aof=1" // HR-Omega936Project-Mobile (ID: 1078) Pre-landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} else {
//fallback to smartlinks after geo target
    $urls = array(
        "http://ck.gl2021.info/53030?subaffiliate_id=$tracker&session_id=$country$delitel$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id", // Glize Nutra
        "http://ck.glzelnk.com/53653?subaffiliate_id=$tracker&session_id=$country$delitel$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id", // Glize Fitnesssmartlink
        "https://dtrk.slimcdn.com/directclick/?pid=r3osD70AeZ7IQyPv0pjPCaK0Vjg1&wsid=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&subid=$tracker", // SlimSpots mainstream smartlink
        "https://newgamesapp.net/?id=45268&clickid=sublimerevenue-mainstream&clickid2=smartlink&clickid3=$tracker&clickid4=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id", // BitterStrawberry mainstream smartlink
        "https://1d5df208093.traffic-c.com/?p=5221&media_type=mainstream&pi=$tracker&click_id=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id" // TrafficCompany mainstream smartlink
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
//geo target first with geo direct offer smartlinks or simply smartlinks if offers are good for this geo
if ( $country == "BG" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1258&aff_id=10787&pid=83065&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // BG-Omega936Project-Desktop (ID: 1258) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "BG" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1258&aff_id=10787&pid=83068&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=direct-offer&mbbr=1&pof=1&aof=1" // BG-Omega936Project-Desktop (ID: 1258) Pre-landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "GR" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1140&aff_id=10787&pid=73179&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // GR-Omega936Project-Desktop (ID: 1140) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "GR" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1140&aff_id=10787&pid=73229&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=direct-offer&mbbr=1&pof=1&aof=1" // GR-Omega936Project-Desktop (ID: 1140) Pre-landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SI" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1138&aff_id=10787&pid=73176&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // SI-Omega936Project-Desktop (ID: 1138) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SI" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1138&aff_id=10787&pid=73180&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=direct-offer&mbbr=1&pof=1&aof=1" // SI-Omega936Project-Desktop (ID: 1138) Pre-landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "RO" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1123&aff_id=10787&pid=71731&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // RO-Omega936Project-Desktop (ID: 1123) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "RO" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1123&aff_id=10787&pid=73061&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=direct-offer&mbbr=1&pof=1&aof=1" // RO-Omega936Project-Desktop (ID: 1123) Pre-landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "CZ" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1120&aff_id=10787&pid=72655&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // CZ-Omega936Project-Desktop (ID: 1120) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "CZ" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1120&aff_id=10787&pid=72657&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // CZ-Omega936Project-Desktop (ID: 1120) Pre-landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "PL" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1118&aff_id=10787&pid=72653&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // PL-Omega936Project-Desktop (ID: 1118) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "PL" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1118&aff_id=10787&pid=72661&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=direct-offer&mbbr=1&pof=1&aof=1" // PL-Omega936Project-Desktop (ID: 1118) Pre-landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "HR" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1077&aff_id=10787&pid=62335&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // HR-Omega936Project-Desktop (ID: 1077) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "HR" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1077&aff_id=10787&pid=66336&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=direct-offer&mbbr=1&pof=1&aof=1" // HR-Omega936Project-Desktop (ID: 1077) Pre-landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SK" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1060&aff_id=10787&pid=62300&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // SK-Omega936Project-Desktop (ID: 1060) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SK" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1060&aff_id=10787&pid=62300&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=direct-offer&mbbr=1&pof=1&aof=1" // SK-Omega936Project-Desktop (ID: 1060) Pre-landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "IT" && $link == "349" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1059&aff_id=10787&pid=62299&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=direct-offer&mbbr=1&pof=1&aof=1" // IT-Omega936Project-Desktop (ID: 1059) Landing
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "IT" && $link == "350" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1059&aff_id=10787&pid=62299&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=direct-offer&mbbr=1&pof=1&aof=1" // IT-Omega936Project-Desktop (ID: 1059) Pre-landing
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