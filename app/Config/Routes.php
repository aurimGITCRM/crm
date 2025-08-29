<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('/LoginVerify', 'Login::verify');
$routes->get('/LogOut', 'Login::logout');

//utenti
$routes->get('/Users', 'Users::get_users');
$routes->get('/InsertUser', 'Users::get_user');
$routes->get('/UpdateUser/(:num)', 'Users::get_user/$1');
$routes->post('/modify_user', 'Users::modify_user');
$routes->get('/delUser/(:num)', 'Users::delUser/$1');
$routes->get('/SearchUser/(:num)', 'Users::search/$1');
$routes->get('/ResettaPwd/(:num)', 'Users::resetPwd/$1');
$routes->get('/ChangePwd', 'Users::changePwd');
$routes->post('/ChangePwd', 'Users::changePwd');
$routes->post('/UpdatePwd', 'Users::updatePwd');


//prodotti
$routes->get('/MacroProducts', 'Products::get_macro_products');
$routes->get('/InsertMacroProducts', 'Products::insert_update_macro_products');
$routes->get('/UpdateMacroProducts/(:num)', 'Products::insert_update_macro_products/$1');
$routes->post('/modify_macro_prodotto', 'Products::modify_macro_prodotto');
$routes->get('/DeleteMacroProducts/(:num)', 'Products::delete_macro_products/$1');
$routes->get('/Products', 'Products::get_products');
$routes->get('/InsertProducts', 'Products::insert_update_products');
$routes->get('/UpdateProducts/(:num)', 'Products::insert_update_products/$1');
$routes->post('/modify_prodotto', 'Products::modify_prodotto');
$routes->get('/DeleteProducts/(:num)', 'Products::delete_products/$1');

//campagne
$routes->get('/Campagne', 'Campagne::index');
$routes->get('/InsertCampagna', 'Campagne::get_campagna');
$routes->get('/UpdateCampagna/(:num)', 'Campagne::get_campagna/$1');
$routes->post('/modify_campagna', 'Campagne::modify_campagna');
$routes->get('/delCampaign/(:num)', 'Campagne::delCamp/$1');

//campagne utenti
$routes->get('/CampagneUtenti', 'Campagne::getCampagneUtenti');
$routes->get('/InsertCampagneUtenti/(:num)/(:num)', 'Campagne::insertCampagneUtenti/$1/$2');
$routes->get('/DeleteCampagneUtenti/(:num)/(:num)', 'Campagne::delCampagneUtenti/$1/$2');

//campagne esiti
$routes->get('/CampagneEsiti', 'Campagne::getCampagneEsiti');
$routes->get('/InsertCampagneEsiti/(:num)/(:num)', 'Campagne::insertCampagneEsiti/$1/$2');
$routes->get('/DeleteCampagneEsiti/(:num)/(:num)', 'Campagne::delCampagneEsiti/$1/$2');

//campagne esiti destinazioni
$routes->get('/CampagneEsitiDestinazioni/(:num)/(:num)', 'Campagne::get_campagne_esiti_destinazioni/$1/$2');
$routes->get('/DeleteCampagneEsitiDestinazioni/(:num)/(:num)/(:num)', 'Campagne::deleteCampagneEsitiDestinazioni/$1/$2/$3');
$routes->post('/UpdateInsertCampagneEsitiDestinazioni', 'Campagne::updateinsertCampagneEsitiDestinazioniAjax');
$routes->get('/getUtentiEsitiCampagnaAjax/(:num)', 'Campagne::getUtentiEsitiCampagnaAjax/$1');

//campagne attivita
$routes->get('/CampagneAttivita/(:num)', 'Campagne::get_campagne_attivita/$1');
$routes->get('/InsertCampagneAttivita/(:num)/(:num)', 'Campagne::insertCampagneAttivita/$1/$2');
$routes->get('/DeleteCampagneAttivita/(:num)/(:num)', 'Campagne::delCampagneAttivita/$1/$2');

//campagne macro prodotti
$routes->get('/CampagneMacro/(:num)', 'Campagne::get_campagne_macro/$1');
$routes->get('/InsertCampagneMacro/(:num)/(:num)', 'Campagne::insertCampagneMacro/$1/$2');
$routes->get('/DeleteCampagneMacro/(:num)/(:num)', 'Campagne::delCampagneMacro/$1/$2');


//esiti
$routes->get('/Esiti', 'Esiti::index');
$routes->get('/InsertEsito', 'Esiti::get_esito');
$routes->get('/UpdateEsito/(:num)', 'Esiti::get_esito/$1');
$routes->post('/modify_esito', 'Esiti::modify_esito');
$routes->get('/delEsito/(:num)', 'Esiti::delEsito/$1');

//attivita
$routes->get('/Attivita', 'Attivita::index');
$routes->get('/InsertAttivita', 'Attivita::get_attivita');
$routes->get('/UpdateAttivita/(:num)', 'Attivita::get_attivita/$1');
$routes->post('/modify_attivita', 'Attivita::modify_attivita');
$routes->get('/delAttivita/(:num)', 'Attivita::delAttivita/$1');

//contatti webvista
$routes->get('/ContattiWebVista', 'ContattiWebVista::get_contatti');
$routes->get('/InsertContattoWebVista', 'ContattiWebVista::get_contatto');
$routes->get('/UpdateContattoWebVista/(:num)', 'ContattiWebVista::get_contatto/$1');
$routes->post('/modify_contatto_webvista', 'ContattiWebVista::modify_contatto');
$routes->post('/modify_contatto_webvista_ajax', 'ContattiWebVista::modify_contatto_ajax');
$routes->post('/modify_esito_webvista_ajax', 'ContattiWebVista::updateCampagneContattiWebVistaAjax');
$routes->get('/delContattoWebVista/(:num)', 'ContattiWebVista::delContatto/$1');
$routes->post('/invio_presentazione_ajax', 'ContattiWebVista::invioPresCampagneContattiWebVistaAjax');
$routes->post('/modify_ordine_webvista_ajax', 'ContattiWebVista::updateCampagneContattiWebVistaOrdineAjax');

//appuntamenti 
$routes->get('/vend_camp_vdt_mcp_ajax/(:num)/(:num)', 'Campagne::getVenditoriCampagneVenditaMacroProdottoSchedaturaAjax/$1/$2');
$routes->post('/app_webvista_ajax', 'Appointment::createApp');


//campagne contatti webvista
$routes->get('/CampagneContattoUtenteWebVista/(:num)/(:num)', 'Campagne::getContattoWebinvista/$1/$2');
$routes->get('/CampagneContattiLiberoWebVista/(:num)', 'Campagne::getContattoWebinvistaLibero/$1');
$routes->get('/CampagneContattiUtenteWebVista/(:num)', 'Campagne::getContattiUtenteWebvista/$1');

//campagne contatti 
$routes->get('/CampagneContatti', 'Campagne::getCampagneUtenti');

//ricerca
$routes->get('/searchUser', 'ajax::searchUser');
$routes->get('/searchAttivita', 'ajax::searchAttivita');
$routes->get('/searchProvince', 'ajax::searchProvince');
$routes->get('/searchTipologia', 'ajax::searchTipologia');

$routes->get('/ListaFilePDF', 'Users::ListaFilePDF');
$routes->get('/partitionUsers', 'Users::getUsersPartition');

//batch 
$routes->get('/send_mail_alert_rinnovo_plugin', 'Batch::sendMailAlertRinnovoPlugin');
$routes->get('/send_mail_alert_rinnovo_dominio', 'Batch::sendMailAlertRinnovoDominio');
$routes->get('/send_mail_promemoria_app', 'Batch::sendMailPromemoriaAppuntamento');
$routes->get('/send_mail_lsta_mailchimp', 'Batch::sendMailListMailChimp');

//upload file 
$routes->get('/upload_contacts', 'UploadController::index');
$routes->post('/upload_contacts', 'UploadController::upload');





