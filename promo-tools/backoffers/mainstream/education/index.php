<?php
include "/var/www/sublimerevenue.com/API/config.php";

//get aff id from backoffer
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
// geo target first with geo direct offer backoffers or simply backoffers if offers are good for this geo
if ( $country == "PT" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1218&aff_id=10787&pid=77874&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // PT-PinguLingo-Mobile (ID: 1218)
        "https://gltrak.com/aff_c2.php?offer_id=1218&aff_id=10787&pid=77873&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1" // PT-PinguLingo-Mobile (ID: 1218)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "MK" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1198&aff_id=10787&pid=76976&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // MK-PinguLingo-Mobile (ID: 1198)
        "https://gltrak.com/aff_c2.php?offer_id=1198&aff_id=10787&pid=77013&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1" // MK-PinguLingo-Mobile (ID: 1198)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "RS" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1253&aff_id=10787&pid=82964&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // RS-LerneLingu-Mobile (ID: 1253)
        "https://gltrak.com/aff_c2.php?offer_id=1253&aff_id=10787&pid=82975&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1", // RS-LerneLingu-Mobile (ID: 1253)
        "https://gltrak.com/aff_c2.php?offer_id=1196&aff_id=10787&pid=76974&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // RS-PinguLingo-Mobile (ID: 1196)
        "https://gltrak.com/aff_c2.php?offer_id=1196&aff_id=10787&pid=77008&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1" // RS-PinguLingo-Mobile (ID: 1196)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "BA" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1257&aff_id=10787&pid=82961&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // BA-LerneLingu-Mobile (ID: 1257)
        "https://gltrak.com/aff_c2.php?offer_id=1257&aff_id=10787&pid=82971&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1", // BA-LerneLingu-Mobile (ID: 1257)
        "https://gltrak.com/aff_c2.php?offer_id=1194&aff_id=10787&pid=76978&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // BA-PinguLingo-Mobile (ID: 1194)
        "https://gltrak.com/aff_c2.php?offer_id=1194&aff_id=10787&pid=77017&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1" // BA-PinguLingo-Mobile (ID: 1194)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "GR" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1188&aff_id=10787&pid=74861&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // GR-PinguLingo-Mobile (ID: 1188)
        "https://gltrak.com/aff_c2.php?offer_id=1188&aff_id=10787&pid=74871&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1" // GR-PinguLingo-Mobile (ID: 1188)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "IT" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1186&aff_id=10787&pid=74876&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // IT-PinguLingo-Mobile (ID: 1186)
        "https://gltrak.com/aff_c2.php?offer_id=1186&aff_id=10787&pid=74878&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1" // IT-PinguLingo-Mobile (ID: 1186)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "PL" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1255&aff_id=10787&pid=82966&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // PL-LerneLingu-Mobile (ID: 1255)
        "https://gltrak.com/aff_c2.php?offer_id=1255&aff_id=10787&pid=82979&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1", // PL-LerneLingu-Mobile (ID: 1255)
        "https://gltrak.com/aff_c2.php?offer_id=1176&aff_id=10787&pid=74657&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // PL-PinguLingo-Mobile (ID: 1176)
        "https://gltrak.com/aff_c2.php?offer_id=1176&aff_id=10787&pid=74659&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1" // PL-PinguLingo-Mobile (ID: 1176)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "HR" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1265&aff_id=10787&pid=84173&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // HR-LerneLingu-Mobile (ID: 1265)
        "https://gltrak.com/aff_c2.php?offer_id=1265&aff_id=10787&pid=84181&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1", // HR-LerneLingu-Mobile (ID: 1265)
        "https://gltrak.com/aff_c2.php?offer_id=1163&aff_id=10787&pid=73862&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // HR-PinguLingo-Mobile (ID: 1163)
        "https://gltrak.com/aff_c2.php?offer_id=1163&aff_id=10787&pid=73885&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1" // HR-PinguLingo-Mobile (ID: 1163)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "BG" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1159&aff_id=10787&pid=73334&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // BG-PinguLingo-Mobile (ID: 1159)
        "https://gltrak.com/aff_c2.php?offer_id=1159&aff_id=10787&pid=73363&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1" // BG-PinguLingo-Mobile (ID: 1159)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SK" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1157&aff_id=10787&pid=73332&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // SK-PinguLingo-Mobile (ID: 1157)
        "https://gltrak.com/aff_c2.php?offer_id=1157&aff_id=10787&pid=73350&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1" // SK-PinguLingo-Mobile (ID: 1157)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "RO" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1155&aff_id=10787&pid=73328&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // RO-PinguLingo-Mobile (ID: 1155)
        "https://gltrak.com/aff_c2.php?offer_id=1155&aff_id=10787&pid=73347&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1" // RO-PinguLingo-Mobile (ID: 1155)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SI" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1267&aff_id=10787&pid=84183&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // SI-LerneLingu-Mobile (ID: 1267)
        "https://gltrak.com/aff_c2.php?offer_id=1267&aff_id=10787&pid=84185&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1", // SI-LerneLingu-Mobile (ID: 1267)
        "https://gltrak.com/aff_c2.php?offer_id=1153&aff_id=10787&pid=73324&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // SI-PinguLingo-Mobile (ID: 1153)
        "https://gltrak.com/aff_c2.php?offer_id=1153&aff_id=10787&pid=73343&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1" // SI-PinguLingo-Mobile (ID: 1153)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "HU" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1151&aff_id=10787&pid=73339&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // HU-PinguLingo-Mobile (ID: 1151)
        "https://gltrak.com/aff_c2.php?offer_id=1151&aff_id=10787&pid=73360&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1" // HU-PinguLingo-Mobile (ID: 1151)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "CZ" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1263&aff_id=10787&pid=84171&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // CZ-LerneLingu-Mobile (ID: 1263)
        "https://gltrak.com/aff_c2.php?offer_id=1263&aff_id=10787&pid=84176&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1", // CZ-LerneLingu-Mobile (ID: 1263)
        "https://gltrak.com/aff_c2.php?offer_id=1149&aff_id=10787&pid=73336&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile&creative=backoffer&mbbr=1&pof=1&aof=1", // CZ-PinguLingo-Mobile (ID: 1149)
        "https://gltrak.com/aff_c2.php?offer_id=1149&aff_id=10787&pid=73354&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=mobile2&creative=backoffer&mbbr=1&pof=1&aof=1" // CZ-PinguLingo-Mobile (ID: 1149)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} else {
//fallback to backoffers after geo target
    $urls = array(
        "https://1d5df208093.traffic-c.com/?p=5221&media_type=mainstream&pi=$tracker&click_id=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id", // TrafficCompany mainstream backoffer
        "https://dtrk.slimcdn.com/directclick/?pid=r3osD70AeZ7IQyPv0pjPCaK0Vjg1&wsid=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&subid=$tracker", // SlimSpots mainstream backoffer
        "https://newgamesapp.net/?id=45268&clickid=sublimerevenue-mainstream&clickid2=backoffer&clickid3=$tracker&clickid4=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id" // BitterStrawberry mainstream backoffer
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
//geo target first with geo direct offer backoffers or simply backoffers if offers are good for this geo
if ( $country == "PT" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1217&aff_id=10787&pid=77939&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // PT-PinguLingo-Desktop (ID: 1217)
        "https://gltrak.com/aff_c2.php?offer_id=1217&aff_id=10787&pid=77872&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1" // PT-PinguLingo-Desktop (ID: 1217)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "MK" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1197&aff_id=10787&pid=76977&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // MK-PinguLingo-Desktop (ID: 1197)
        "https://gltrak.com/aff_c2.php?offer_id=1197&aff_id=10787&pid=77014&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1" // MK-PinguLingo-Desktop (ID: 1197)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "RS" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1252&aff_id=10787&pid=82965&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // RS-LerneLingu-Desktop (ID: 1252)
        "https://gltrak.com/aff_c2.php?offer_id=1252&aff_id=10787&pid=82976&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1", // RS-LerneLingu-Desktop (ID: 1252)
        "https://gltrak.com/aff_c2.php?offer_id=1195&aff_id=10787&pid=76973&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // RS-PinguLingo-Desktop (ID: 1195)
        "https://gltrak.com/aff_c2.php?offer_id=1195&aff_id=10787&pid=77010&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1" // RS-PinguLingo-Desktop (ID: 1195)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "BA" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1256&aff_id=10787&pid=82960&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // BA-LerneLingu-Desktop (ID: 1256)
        "https://gltrak.com/aff_c2.php?offer_id=1256&aff_id=10787&pid=82970&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1", // BA-LerneLingu-Desktop (ID: 1256)
        "https://gltrak.com/aff_c2.php?offer_id=1193&aff_id=10787&pid=76979&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // BA-PinguLingo-Desktop (ID: 1193)
        "https://gltrak.com/aff_c2.php?offer_id=1193&aff_id=10787&pid=77016&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1" // BA-PinguLingo-Desktop (ID: 1193)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "GR" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1187&aff_id=10787&pid=74862&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // GR-PinguLingo-Desktop (ID: 1187)
        "https://gltrak.com/aff_c2.php?offer_id=1187&aff_id=10787&pid=74870&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1" // GR-PinguLingo-Desktop (ID: 1187)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "IT" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1185&aff_id=10787&pid=74875&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // IT-PinguLingo-Desktop (ID: 1185)
        "https://gltrak.com/aff_c2.php?offer_id=1185&aff_id=10787&pid=74879&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1" // IT-PinguLingo-Desktop (ID: 1185)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "PL" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1254&aff_id=10787&pid=82967&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // PL-LerneLingu-Desktop (ID: 1254)
        "https://gltrak.com/aff_c2.php?offer_id=1254&aff_id=10787&pid=82981&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1", // PL-LerneLingu-Desktop (ID: 1254)
        "https://gltrak.com/aff_c2.php?offer_id=1175&aff_id=10787&pid=74658&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // PL-PinguLingo-Desktop (ID: 1175)
        "https://gltrak.com/aff_c2.php?offer_id=1175&aff_id=10787&pid=74660&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1" // PL-PinguLingo-Desktop (ID: 1175)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "HR" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1264&aff_id=10787&pid=84172&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // HR-LerneLingu-Desktop (ID: 1264)
        "https://gltrak.com/aff_c2.php?offer_id=1264&aff_id=10787&pid=84180&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1", // HR-LerneLingu-Desktop (ID: 1264)
        "https://gltrak.com/aff_c2.php?offer_id=1162&aff_id=10787&pid=73840&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // HR-PinguLingo-Desktop (ID: 1162)
        "https://gltrak.com/aff_c2.php?offer_id=1162&aff_id=10787&pid=73884&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1" // HR-PinguLingo-Desktop (ID: 1162)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "EE" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1161&aff_id=10787&pid=73679&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // EE-PinguLingo-Desktop (ID: 1161)
        "https://gltrak.com/aff_c2.php?offer_id=1161&aff_id=10787&pid=73680&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1" // EE-PinguLingo-Desktop (ID: 1161)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "LV" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1160&aff_id=10787&pid=73335&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // LV-PinguLingo-Desktop (ID: 1160)
        "https://gltrak.com/aff_c2.php?offer_id=1160&aff_id=10787&pid=73366&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1" // LV-PinguLingo-Desktop (ID: 1160)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "BG" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1158&aff_id=10787&pid=73333&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // BG-PinguLingo-Desktop (ID: 1158)
        "https://gltrak.com/aff_c2.php?offer_id=1158&aff_id=10787&pid=73364&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1" // BG-PinguLingo-Desktop (ID: 1158)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SK" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1156&aff_id=10787&pid=73331&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // SK-PinguLingo-Desktop (ID: 1156)
        "https://gltrak.com/aff_c2.php?offer_id=1156&aff_id=10787&pid=73351&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1" // SK-PinguLingo-Desktop (ID: 1156)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "RO" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1154&aff_id=10787&pid=73329&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // RO-PinguLingo-Desktop (ID: 1154)
        "https://gltrak.com/aff_c2.php?offer_id=1154&aff_id=10787&pid=73346&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1" // RO-PinguLingo-Desktop (ID: 1154)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "SI" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1266&aff_id=10787&pid=84182&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // SI-LerneLingu-Desktop (ID: 1266)
        "https://gltrak.com/aff_c2.php?offer_id=1266&aff_id=10787&pid=84184&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1", // SI-LerneLingu-Desktop (ID: 1266)
        "https://gltrak.com/aff_c2.php?offer_id=1152&aff_id=10787&pid=73325&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // SI-PinguLingo-Desktop (ID: 1152)
        "https://gltrak.com/aff_c2.php?offer_id=1152&aff_id=10787&pid=73342&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1" // SI-PinguLingo-Desktop (ID: 1152)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "HU" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1150&aff_id=10787&pid=73338&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // HU-PinguLingo-Desktop (ID: 1150)
        "https://gltrak.com/aff_c2.php?offer_id=1150&aff_id=10787&pid=73359&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1" // HU-PinguLingo-Desktop (ID: 1150)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} elseif ( $country == "CZ" ) { 
    $urls = array(
        "https://gltrak.com/aff_c2.php?offer_id=1262&aff_id=10787&pid=84170&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // CZ-LerneLingu-Desktop (ID: 1262)
        "https://gltrak.com/aff_c2.php?offer_id=1262&aff_id=10787&pid=84175&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1", // CZ-LerneLingu-Desktop (ID: 1262)
        "https://gltrak.com/aff_c2.php?offer_id=1148&aff_id=10787&pid=73337&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop&creative=backoffer&mbbr=1&pof=1&aof=1", // CZ-PinguLingo-Desktop (ID: 1148)
        "https://gltrak.com/aff_c2.php?offer_id=1148&aff_id=10787&pid=73356&aff_sub=$tracker&aff_sub2=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&source=desktop2&creative=backoffer&mbbr=1&pof=1&aof=1" // CZ-PinguLingo-Desktop (ID: 1148)
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
} else {
//fallback to backoffers after geo target
    $urls = array(
        "https://1d5df208093.traffic-c.com/?p=5221&media_type=mainstream&pi=$tracker&click_id=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id", // TrafficCompany mainstream backoffer
        "https://dtrk.slimcdn.com/directclick/?pid=r3osD70AeZ7IQyPv0pjPCaK0Vjg1&wsid=$tid11$delitel$tid22$delitel$tid33$delitel$tid44$delitel$set$delitel$link$delitel$sub_id&subid=$tracker" // SlimSpots mainstream backoffer
    );
    $url = $urls[array_rand($urls)];
    checkUrl($url, $urls);
}
// desktop traffic end
}
?>