<?php

use App\Controllers\AddClientController;
use App\Controllers\AuthController;
use App\Controllers\ChartController;
use App\Controllers\CommandeController;
use App\Controllers\CongeController;
use App\Controllers\CreatingController;
use App\Controllers\DevisController;
use App\Controllers\EmployeesController;
use App\Controllers\FactureController;
use App\Controllers\FullCalendarController;
use App\Controllers\NotificationController;
use App\Controllers\PermissionController;
use App\Controllers\RapportController;
use App\Controllers\RelanceController;
use App\Controllers\ServiceController;
use App\Controllers\SouTacheController;
use App\Controllers\TacheController;
use App\Controllers\VenteController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ---------- routes d'authentification ------------
$routes->get('/' , [ChartController::class,'index']);

$routes->get('/login' ,[AuthController::class , 'index']);

$routes->post('/logged' ,[AuthController::class , 'login']);

$routes->get('/logout' ,[AuthController::class , 'logout']);
// ---------- fin routes d'authentification ------------

// ---------- route pour les commerciaux ------------
$routes->get('/Commeciale', [EmployeesController::class,'index']);

$routes->get('/Commeciale/ajouter' , [EmployeesController::class , 'create']);

$routes->post('/Commeciale/save' , [EmployeesController::class , 'store']);

$routes->get('/Commeciale/edit/(:num)' , [EmployeesController::class , 'edit/$1']);

$routes->get('/getEmployeeInfo/(:segment)' , [EmployeesController::class , 'getEmployeeInfo/$1']);

$routes->post('/Commeciale/update/(:num)' , [EmployeesController::class , 'update/$1']);

$routes->get('/Commerciale/permissions/(:num)' , [EmployeesController::class , 'permission/$1']);

$routes->get('/Commerciale/details/(:num)' , [EmployeesController::class , 'show/$1']);

$routes->get('/Commeciale/detele/(:num)' , [EmployeesController::class , 'delete/$1']);
// ---------- fin route pour les commerciaux -----------


// ---------- route pour les Taches ------------
$routes->get('/taches' , [TacheController::class , 'index']);

$routes->get('/taches/ajout' , [TacheController::class , 'create']);

$routes->post('/tache/save' , [TacheController::class , 'store']);

$routes->get('/taches/edit/(:num)' , [TacheController::class , 'edit/$1']);

$routes->post('/taches/update/(:num)' , [TacheController::class , 'update/$1']);

$routes->get('taches/delete/(:num)' , [TacheController::class , 'delete/$1']);

$routes->get('/taches/details/(:num)' , [TacheController::class , 'show/$1']);

$routes->get('TacheController/updateStatut/(:num)' , [TacheController::class , 'updateStatut/$1']);

// ---------- fin route pour les Taches ------------


// ---------- route pour les sous Taches ------------
$routes->get('delete_souT/(:num)' , [SouTacheController::class , 'delete/$1']);

$routes->get('/taches/ajoutsous' , [TacheController::class , 'create']);

$routes->post('/taches/save/(:num)' , [SouTacheController::class , 'store/$1']);

$routes->get('SouTacheController/updateStatut/(:num)/(:num)' , [SouTacheController::class , 'updateStatut/$1/$2']);
// ---------- fin route pour les sous Taches ------------

// ---------- route pour les sous conges ------------
$routes->get('/conge' , [CongeController::class , 'index']);

$routes->get('/conge/ajouter' , [CongeController::class , 'create']);

$routes->post('/conje/save' , [CongeController::class , 'store']);

$routes->get('conge/edit/(:num)' , [CongeController::class , 'edit/$1']);

$routes->post('conge/update/(:num)' , [CongeController::class , 'update/$1']);

$routes->get('/conge/details/(:num)' , [CongeController::class , 'show/$1']);

$routes->get('delete_conge/(:num)' , [CongeController::class , 'delete/$1']);
// ---------- fin route pour les conges ------------

// ---------- route pour l'excel ------------
$routes->get('exportToExcel', [EmployeesController::class,'exportToExcel']);

$routes->get('export-taches', [TacheController::class,'exportToExcel']);

$routes->get('export-soutaches', [SouTacheController::class , 'exportToExcel']);

$routes->get('export-conges', 'CongeController::exportToExcel');
// ---------- fin route pour l'excel ------------

// ----------- Routes juste Pour Le Calendrier ---------
$routes->get("/calendrier" , [FullCalendarController::class , 'index']);

$routes->get('FullCalendarController/create', [FullCalendarController::class,'create']);

$routes->post('FullCalendarController/create', [FullCalendarController::class,'create']);

$routes->get('FullCalendarController/update/(:num)', [FullCalendarController::class,'update/$1']);

$routes->post('FullCalendarController/update/(:num)', [FullCalendarController::class,'update/$1']);

$routes->get('FullCalendarController/delete/(:num)', [FullCalendarController::class,'delete/$1']);

$routes->post('FullCalendarController/delete/(:num)', [FullCalendarController::class,'delete/$1']);

$routes->get('fullcalendar/load', [FullCalendarController::class,'load']);
// ----------- Fin Routes Calendrier ---------


// ---------- routes pour les Notifications -------------
$routes->get('notifications', [NotificationController::class ,'index']);

$routes->get('notifications/markAsRead/(:num)', 'NotificationController::markAsRead/$1');

$routes->get('notification/markAsReadAndRedirectToTask/(:num)', 'NotificationController::markAsReadAndRedirectToTask/$1');

$routes->get('notification/markTaskAsRead/(:num)', 'NotificationController::markTaskAsRead/$1');
$routes->get('/markNotificationsAsSeen', [NotificationController::class , 'SeenNotifications']);
// ---------- Fin routes pour les Notifications -------------

// --------- route pour les devis -------------
$routes->get('devis',[DevisController::class , 'liste']);

$routes->get('/devis/ajouter',[DevisController::class , 'ajouterdevis']);

$routes->get('/Controllers/DevisController/getServiceInfo/(:num)', [DevisController::class , 'getServiceInfo/$1']);

$routes->get('/Controllers/DevisController/generatedIdDevis/(:segment)',[DevisController::class , 'generatedIdDevis/$1']);

$routes->post('/devis/save',[DevisController::class , 'store']);

$routes->get('/devis/delete/(:segment)',[DevisController::class , 'delete/$1']);

$routes->get('/devis/details/(:segment)',[DevisController::class , 'showdevis/$1']);

$routes->get('/devis/modifier/(:num)',[DevisController::class , 'edit/$1']);

$routes->post('/devis/update/(:num)',[DevisController::class , 'update/$1']);
// --------- fin route pour les devis -------------

// --------- route pour les Factures -------------
$routes->get('/facture', [FactureController::class, 'index'], ['as' => 'facture']);

$routes->match(['get', 'post'], '/search', [FactureController::class,'search']);

$routes->match(['get', 'post'], '/Bydate', [FactureController::class,'searchByDate']);

$routes->get('/facture/ajouter/(:num)',[CreatingController::class,'create/$1']);

$routes->get('/Controllers/CreatingController/generatedId/(:segment)',[CreatingController::class , 'generatedId/$1']);

$routes->get('/Controllers/FactureController/generatedId/(:segment)',[CreatingController::class , 'generatedId/$1']);

$routes->get('/Controllers/CreatingController/generatedDevis/(:segment)',[CreatingController::class , 'generatedDevis/$1']);

$routes->post('/facture/save', [CreatingController::class , 'createData']);

$routes->get('/facture/modifier/(:num)/(:segment)',[FactureController::class , 'editFacture/$1/$2']);

$routes->post('/facture/update/(:segment)',[FactureController::class , 'updateFacture/$1']);

$routes->get('/facture/delete/(:segment)', [CreatingController::class , 'delete_row/$1']);
// --------- fin route pour les Factures -------------



// --------- route pour les Relancement -------------
$routes->get('/liste' , [RelanceController::class , 'Relance']);

$routes->get('/client/updateRelancement/(:segment)', [RelanceController::class , 'updateRelancement/$1']);
// --------- fin route pour les Relancement -------------



// ---------- route pour les Clinets ------------

$routes->get('/client',[AddClientController::class , 'liste']);

$routes->get('/client/ajouter',[AddClientController::class , 'index']);

$routes->post('/client/save',[AddClientController::class , 'store']);

$routes->get('client/modifier/(:num)',[AddClientController::class , 'edit/$1']);

$routes->post('/client/update/(:num)',[AddClientController::class , 'update/$1']);

$routes->get('/client/delete/(:num)',[AddClientController::class , 'delete/$1']);

$routes->get('client/details/commande/(:num)',[AddClientController::class , 'show/$1']);

// ---------- fin route pour les Clinets ------------


// ---------- route pour les Avances Des Clinets ------------

$routes->get('/client/avance',[AddClientController::class , 'avance']);

$routes->get('/client/avance/ajouter',[AddClientController::class , 'AddAvance']);

$routes->post('/avance/save',[AddClientController::class , 'StoreAvance']);

$routes->get('/client/avance/ajouterRe',[AddClientController::class , 'addAvanceRetour']);

$routes->get('/avance/modifier/(:num)',[AddClientController::class , 'editAvance/$1']);

$routes->post('/avance/update/(:num)',[AddClientController::class , 'UpdateAvance/$1']);

// ---------- fin route pour les Avances Des Clinets ------------


// ---------- route pour les services ------------

$routes->get('/service',[ServiceController::class , 'liste']);

$routes->get('/service/ajouter',[ServiceController::class , 'index']);

$routes->post('/service/save', [ServiceController::class , 'store']);

$routes->get('service/modifier/(:num)',[ServiceController::class , 'edit/$1']);

$routes->post('/service/update/(:num)',[ServiceController::class , 'update/$1']);
// ---------- fin route pour les services ------------

$routes->get('generate-pdf-line/(:segment)', 'DevisController::generatePdfForLine/$1');

$routes->get('generate-pdf-facture/(:segment)', 'FactureController::generatePdfForFacture/$1');

$routes->post('/searchClient','AddClientController::searchClient');

// -------- routes pour les commandes ----------
$routes->get('/commande' , [CommandeController::class , 'index']);

$routes->get('/commande/ajouter' , [CommandeController::class , 'create']);

$routes->post('commande/store' , [CommandeController::class , 'store']);

$routes->get('commande/modifier/(:num)', [CommandeController::class , 'edit/$1']);

$routes->post('commande/update/(:num)', [CommandeController::class , 'update/$1']);

$routes->get('commande/show/(:num)', [CommandeController::class , 'show/$1']);

$routes->get('commande/annuler/(:num)', [CommandeController::class , 'annuler/$1']);

$routes->add('commande/update_annuler/(:num)', [CommandeController::class , 'updateAnnuler/$1']);
// -------- fin routes pour les commandes ----------

// -------- routes pour les Ventes ----------
$routes->get('/Vente' , [VenteController::class , 'index']);

$routes->get('/Vente/ajouter/(:num)' , [VenteController::class , 'create/$1']);

$routes->post('/vente/store' , [VenteController::class , 'store']);

$routes->get('/vente/modifier/(:num)' , [VenteController::class , 'edit/$1']);

$routes->post('/vente/update/(:num)' , [VenteController::class , 'update/$1']);

$routes->post('rest/update/(:num)' , [VenteController::class , 'updateReste/$1']);

$routes->post('update/cheque/(:num)' , [VenteController::class , 'UpdateCheque/$1']);

$routes->get('vente/details/(:num)' , [VenteController::class , 'show/$1']);

$routes->get("/Controllers/ServiceController/generatedServis/(:num)" , [VenteController::class, "generatedServis/$1"]);

$routes->get("/Controllers/generatedClient/(:num)" , [VenteController::class, "generatedClient/$1"]);

$routes->get("/client/getAvance/(:num)" , [VenteController::class, "generatedAvance/$1"]);
// -------- fin routes pour les Ventes ----------


// -------- routes pour le Profile ----------
$routes->get('/profile/(:num)' , [EmployeesController::class , 'profile/$1']);

$routes->post('/profile/update/(:num)' , [EmployeesController::class , 'updateProfile/$1']);
// -------- fin routes pour le Profile ----------


// -------- routes pour les Rapports ----------
$routes->get('rapports/chiffres/' , [RapportController::class , 'chiffreDaffaires']);

$routes->get('rapports/details_commerciaux/' , [RapportController::class , 'details_commerciaux']);

$routes->get('rapports/service_vendus' , [RapportController::class , 'service_vendus']);
// -------- fin routes pour les Rapports ----------


// -------- routes pour les Permissions ----------

$routes->get('updatePermission/(:num)/(:num)/(:num)', 'PermissionController::updatePermission/$1/$2/$3');

$routes->get('rapports/details_commerciaux/' , [RapportController::class , 'details_commerciaux']);

$routes->get('rapports/service_vendus' , [RapportController::class , 'service_vendus']);
// -------- fin routes pour les Permissions ----------
