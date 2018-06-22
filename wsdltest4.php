<?php
/* Create a class for your webservice structure, in this case: Contact */
$wsdl = 'http://'.$_SERVER['HTTP_HOST'].'/wsdls/AscioService.wsdl';
$session = array( 'session'=>array('Account'=>'VODAFONEGLOBAL','Password'=>'QEm?6rat'));

echo "Before connection: ".date('Y-m-d H:i:s');
echo "<br>";
/* Initialize webservice with your WSDL */
$client = new SoapClient($wsdl,array('verifyhost' => false,  'trace' => 0, 'exceptions' => 1,'stream_context' => stream_context_create(array( 'ssl' => array( 'verify_peer'  => false, 'verify_peer_name'  => false )))));

echo "After connection: ".date('Y-m-d H:i:s');
echo "<br>";

/* Invoke webservice method with your parameters, in this case: Function1 */
$responseSession = $client->__soapCall("LogIn",array('parameters' => $session));

echo "after login: ".date('Y-m-d H:i:s');
echo "<br>";
$createContact =  array( 'sessionId'=>$responseSession->sessionId, 'contact'=> array( 'CreDate'=>date("Y-m-d"), 'Status'=>'Active', 'FirstName'=>'John', 'LastName'=>'Devid', 'Address1'=>'Mlore', 'PostalCode'=>'12123','City'=>'mlore','CountryCode'=>'IN','Email'=>'usha.pr@glowtouch.com','Phone'=>'+45.123456789' ) );

$responseContact = $client->__soapCall("CreateContact",array('parameters' => $createContact));
echo "After contact: ".date('Y-m-d H:i:s');
echo "<br>";
$createRegistrant = array( 'sessionId'=>$responseSession->sessionId, 'registrant'=>array( 'CreDate'=>date("Y-m-d"), 'Status'=>'Active', 'Name'=>'JohnDevid', 'Address1'=>'Mlore', 'PostalCode'=>'12123','City'=>'mlore','CountryCode'=>'IN' ) ); 

$apiResultRegistrantHandle=  $client->__soapCall( 'CreateRegistrant', array('parameters' => $createRegistrant) );
echo "After registrant: ".date('Y-m-d H:i:s');
echo "<br>";

         $CreateOrder = array( 'sessionId'=>$responseSession->sessionId,
                              'order'=>array('OrderId'=>uniqid('A'),
                                       'Type'=>'Register_Domain',
                                       'Status'=>'NotSet',
									   'LocalPresence'=>'None',
                                       'Domain'=>array('DomainName'=>'glowtouchempirethhhh5.it',
                                                       'Status'=>'ACTIVE',
                                                       'CreDate'=>date("Y-m-d"),
                                                       'ExpDate'=>date("Y-m-d"),
													   
                                                       'Registrant'=>array('CreDate'=>date("Y-m-d"),
                                                        'Handle'=>$apiResultRegistrantHandle->registrant->Handle,
                                                        'Email'=>'hostopiatestacc@gmail.com',
                                                        'Name'=>'John Devid', 
                                                        'Address1'=>'Mlore', 
                                                        'PostalCode'=>'12123',
														'State'=>'DS',
                                                        'City'=>'mlore',
														'CountryCode'=>'IT',
														'Phone'=>'+45.123456789',
														'RegistrantType'=>'5',
														'RegistrantNumber'=>'34324234'),
														
                                                        'AdminContact'=>array('CreDate'=>date("Y-m-d"),
                                                        'Handle'=>$responseContact->contact->Handle,
                                                        'Email'=>'hostopiatestacc@gmial.com',
														'FirstName'=>'John',
                                                        'LastName'=>'Devid', 
                                                        'Address1'=>'Mlore', 
                                                        'PostalCode'=>'12123',
                                                        'City'=>'mlore','CountryCode'=>'IT',														
														'State'=>'DS'),
														
                                                        'TechContact'=>array('FirstName'=>'John',
                                                        'LastName'=>'Devid',
                                                        'Address1'=>'Mlore', 
                                                        'PostalCode'=>'12123',
                                                        'City'=>'mlore',
                                                        'CountryCode'=>'IT',
                                                        'Email'=>'hostopiatestacc@gmial.com',
                                                        'Phone'=>'+45.123456789',
														'State'=>'FS'), 
														
                                                        'BillingContact'=>array('CreDate'=>date("Y-m-d"),
                                                        'Handle'=>$responseContact->contact->Handle ),
														
                                                        'ResellerContact'=>array( 'CreDate'=>date("Y-m-d"),
                                                        'Handle'=>$responseContact->contact->Handle ),
														
                                                        'NameServers'=>array('NameServer1'=>array( 'CreDate'=>date("Y-m-d"),'HostName'=>'ns1.carrierzone.com' ),
                                                        'NameServer2'=>array('CreDate'=>date("Y-m-d"),'HostName'=>'ns2.carrierzone.com'),
                                                        'NameServer3'=>array('CreDate'=>date("Y-m-d"),'HostName'=>'ns3.carrierzone.com'),
                                                        'NameServer4'=>array('CreDate'=>date("Y-m-d"),'HostName'=>'ns4.carrierzone.com') ) 
                                                        ),
                                    'CreDate'=>date("Y-m-d") 
                                    ) );       

$apiResultCreateOrder= $client->__soapCall( 'CreateOrder', array('parameters' => $CreateOrder) );
echo "After order: ".date('Y-m-d H:i:s'); 
echo "<br>";   
/* Print webservice response */
echo "<pre>";
var_dump($apiResultCreateOrder);


?>
