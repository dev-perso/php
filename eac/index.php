<?php
header('Content-Type: text/html; charset=utf-8');
setlocale(LC_CTYPE, 'C');
mb_internal_encoding("UTF-8");

/**
 * Nom de votre bureau virtuel
 *
 * @var string
 */
$vd_name = "itlink";

/**
 * Identifiant utilisateur utilisé pour se connecter au service
 *
 * Il s'agit du compte utilisateur que vous avez créé dans
 * Administration > Utilisateurs > Création d'un compte utilisateur
 *
 * l'identifiant web.service n'est qu'un exemple. Vous pouvez définir
 * l'identifiant de votre choix.
 *
 * @var string
 */
$user = "serviceeac.66wuhi2x2m"; // à changer

/**
 * Clé de cryptage de l'utilisateur
 *
 * Celle-ci est renseignée dans l'écran de paramétrage du compte utilisateur.
 *
 * @var string
 */
$salt = "9658d1ce6cd1231e8e366a917274f1975a4ed0e320335c11adebd91ac640c9cb6e6b000c72942b28949e9ddc9bfb88ebb3a28ebd152cc6112c7eaadf"; // à changer

/**
 * Url du fichier wsdl
 * @var string
 */
$wsdl = "https://itlink.extranet-e.net/webservice/1.00/?wsdl";

/**
 * $timestamp et $token sont indispensables afin de pouvoir vous connecter
 * au Service Web. Pour une sécurité maximale, la clé de cryptage n'est jamais
 * transmise sur le réseau (même si les connexions sont cryptées).
 *
 * On calcule un "token" au moyen de la fonction de hachage cryptographique SHA-1.
 *
 * Le token généré n'est jamais le même puisqu'il dépend du moment auquel il est
 * utilisé ($timestamp).
 *
 */
$timestamp = time();
 /*
date_default_timezone_set("Europe/Paris");
echo $timestamp . "<br>";
$date = new DateTime();
echo date('l jS \of F Y h:i:s A') . "<br>";
*/
$token = sha1($user.$salt.$vd_name.$timestamp);

echo "user : " . $user . "<br>";
echo "timestamp : " . $timestamp . "<br>";
echo "token : " . $token . "<br>";

try {

    /**
     * Création d'un client Soap :
     */
    $remote = new SoapClient($wsdl);

    /**
     * Ouverture d'une session sur les Web Services
     *
     * @var unknown_type
     */
    $session = $remote->login($user,$timestamp,$token);

    if (substr($session,0,5)=="error") {
        echo $session;
        exit;
    }

    debug("Session créée : $session");
	
	$type = $remote->contact_type_list($session,'fr');
	echo $type . "<br>";
	
	$selected_type = "169,184";
	//$arrayType = explode(",", $selected_type);
	
	$search = array(
        array('field' => 'ab_type', 'operator' => 'IN', 'value' => '169,184')
    );
	
	var_dump($search);
	//foreach ($arrayType as $type)
	//{
		$data = $remote->contact_list($session,json_encode($search));
		//echo "type : " . $selected_type . " nombre d'élément trouvé : " . $data . "<br>";;
	//}
	
	
	$consultant = $remote->contact_get($session,154098);
	
	$information = json_decode($consultant, true);
	echo '<pre>';
	print_r($information);
	echo '</pre>';
}
 catch(SoapFault $fault) {

    echo $fault;
}

function debug($object) {

    echo '<pre>' . (is_array($object) ? print_r($object,true) : $object) . '</pre>';
}

?>