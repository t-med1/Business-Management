<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    <?php $this->rendersection("title") ?>
  </title>
  <?php $this->rendersection('full')?>
  
	<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.css' rel='stylesheet' />
  <link href='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css' rel='stylesheet' /> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('plugins/select2/css/select2.min.css')?>">
  <link rel="stylesheet" href="<?= base_url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')?>">
  <!-- Inclure Morris.js et ses fichiers CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')?>">
  <?php $this->rendersection("style") ?>
  <link rel="stylesheet" href="<?= base_url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')?>">
  <link rel="stylesheet" href="<?= base_url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')?>">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0-beta3/css/all.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css') ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet"
    href="<?= base_url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url('plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= base_url('plugins/jqvmap/jqvmap.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url('plugins/daterangepicker/daterangepicker.css') ?>">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= base_url('plugins/summernote/summernote-bs4.min.css') ?>">

  <link rel="stylesheet" href="<?= base_url('plugins/datatable.css') ?>">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="<?= base_url('images/favicon1.png') ?>" alt="AdminLTELogo" height="60"
        width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light bg-info" style="color:white;">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="color:white;"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
          <ul class="navbar-nav navbar-nav-right">
                <?php if(session('role') != 'admin'):?>
                  <li class="nav-item dropdown">
                    <?php
                      $notificationModel = new App\Models\Notification;
                      $id_emp = session('id_emp');
                      $totalNewNotifications = $notificationModel->where('showin' , 'unseen')->where('id_emp' , $id_emp)->countAllResults();
                    ?>
                      <a class="nav-link" style="color:white" data-toggle="dropdown" id="notification">
                          <i class="fa fa-bell" aria-hidden="true"></i>
                          <?php if ( isset($totalNewNotifications) && $totalNewNotifications > 0 ): ?>
                              <span class="badge badge-warning navbar-badge" id="notification-badge"><?= $totalNewNotifications ?></span>
                          <?php endif; ?>
                      </a>
                      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                          <?php if (isset($totalNewNotifications) && $totalNewNotifications > 0): ?>
                              <span class="dropdown-item dropdown-header">
                                <?php if($totalNewNotifications > 1):?>
                                  Notfications
                                <?php elseif($totalNewNotifications == 1) :?>
                                  Notification
                                <?php endif;?>
                              </span>
                          <?php endif; ?>
                          <?php
                            $modelTache = new App\Models\Tache;
                            $notificationModel = new App\Models\Notification;
                            $employeeId = session('id_emp');

                            $tachesNonLues = $modelTache
                              ->select('tache.id_tache, tache.description, notifications.created_at')
                              ->join('notifications', 'tache.id_tache = notifications.id_tache')
                              ->where('notifications.id_emp' , $employeeId)
                              ->where('notifications.is_read', 0)
                              ->findAll();

                            foreach ($tachesNonLues as $tache) {
                                $createdDateTime = new DateTime($tache['created_at']);
                                $currentDateTime = new DateTime();
                                $interval = $createdDateTime->diff($currentDateTime);
                                $minutesDiff = $interval->i;

                                ?>
                                <div class="dropdown-divider"></div>
                                <a href="<?= base_url('/taches/details/' . $tache['id_tache']) ?>" class="dropdown-item">
                                    <i class="fas fa-envelope mr-2"></i> <?= $tache['description'] ?>
                                    <span class="float-right text-muted text-sm"><?= $minutesDiff ?> mins</span>
                                </a>
                                <?php
                            }
                          ?>

                      </div>
                  </li>
                <?php endif;?>
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown"
                style="color:white;">
                <span class="nav-profile-name">
                  <?php if (session()->has('role')): ?>
                    <?php
                      echo session('nom').' '.session('prenom');
                    ?>
                  <?php endif; ?>
                </span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="<?= base_url('profile/'.session('id_employe'))?>">
                  <i class="fa fa-user" aria-hidden="true"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="<?= base_url('/logout')?>">
                  <i class="fa fa-sign-out" aria-hidden="true"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= base_url('/dashboard')?>" class="brand-link bg-info" style="width:100% ;display:flex ; justify-content:center; align-items:center;font-size:28px;">
            <span class="logo-lg"><b style="font-weight:bold;">ATLAS </b>GESTION</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?= base_url('images/favicon1.png') ?>" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="/profile" class="d-block">
                <?php if (session()->has('id_employe')): ?>
                  <?php
                  echo session('nom').' '.session('prenom');
                  ?>
                <?php endif; ?><br>
                <i class="fa fa-circle text-success" style="font-size:11px"></i> <span style="font-size:11px">En Ligne</span>
              </a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item menu-open">
              <a href="<?= base_url('/')?>" class="nav-link <?php $this->rendersection('dash') ?>">
                <i class="nav-icon fa fa-home" aria-hidden="true"></i>
                <p>
                  Tableau De Bord
                  <?php
                      $id_emp = session('id_employe');
                      $notificationModel = new App\Models\Notification;
                      $tacheModel = new App\Models\Tache;
                      $venteModel = new App\Models\Vente;
                      $currentDate = date('Y-m-d');
                      $totalNewNotifications = 0;
                      $chequeTotal = $venteModel
                                  ->where('mode_paiement', 'cheque')
                                  ->where('montant_rest > ' , 0 )
                                  ->where('date_cheque <', $currentDate)
                                  ->countAllResults();
                      if(session('role') == 'admin'){
                        $tacheEnRetard = $tacheModel->where('statut' , 'en retard')->countAllResults();
                        if($tacheEnRetard > 0 || $chequeTotal > 0){
                          ?>
                          <span class="right badge badge-danger" data-toggle="tooltip" data-placement="top" title="<?= $chequeTotal > 0 ? 'Chèque à en caissé' : 'Tache En Retard' ?>">
                            <?= $chequeTotal > 0 ? 'Chèque' : 'retard' ?>
                          </span>
                        <?php
                        }
                      }else{
                        $tacheEnRetard = $tacheModel->where('statut' , 'en retard')->where('id_emp' , session('id_employe'))->countAllResults();
                        $totalNewNotifications = $notificationModel->where('showin' , 'unseen')->where('id_emp' , $id_emp)->countAllResults();
                        if($totalNewNotifications > 0){
                          ?>
                            <span class="right badge badge-warning" data-toggle="tooltip" data-placement="top" title="Nouvelle Tache">
                              Nouveau
                            </span>
                          <?php
                        }if($tacheEnRetard > 0){
                          ?>
                          <span class="right badge badge-danger" data-toggle="tooltip" data-placement="top" title="Tache En Retard">
                            retard
                          </span>
                      <?php
                        }
                      }
                     ?>
                </p>
              </a>
            </li>
              <li class="nav-item">
                <a href="<?= base_url('/calendrier')?>" class="nav-link <?php $this->rendersection('calendrier') ?>">
                  <i class="nav-icon fa fa-columns" aria-hidden="true"></i>
                  <p>
                    Planning Du Mois
                  </p>
                </a>
              </li>
              <?php if( session('role') == 'admin'):?>
              <li class="nav-item">
                <a href="#" class="nav-link <?php $this->rendersection('Commeciale') ?>">
                  <i class="fa fa-users nav-icon" aria-hidden="true"></i>
                  <p>
                    Commerciaux
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('/Commeciale/ajouter')?>" class="nav-link <?php $this->rendersection('Commecialeadd') ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ajouter Commeciale</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('/Commeciale')?>" class="nav-link <?php $this->rendersection('Commecialel') ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Liste Des Commerciaux</p>
                    </a>
                  </li>
                </ul>
              </li>
            <?php endif;?>
            <?php if(session('role') == 'assistante commerciale' || session('role') == 'admin'):?>
              <li class="nav-item">
                <a href="#" class="nav-link <?php $this->rendersection('service') ?>">
                  <i class="fa fa-cubes nav-icon" aria-hidden="true"></i>
                  <p>
                    Services
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('/service/ajouter')?>" class="nav-link <?php $this->rendersection('serviceadd') ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ajouter Service</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('/service')?>" class="nav-link <?php $this->rendersection('servicel') ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Liste Des Services</p>
                    </a>
                  </li>
                </ul>
              </li>
            <?php endif; ?>

            <li class="nav-item">
              <a href="#" class="nav-link <?php $this->rendersection('client') ?>">
                <i class="nav-icon fa fa-file-text" aria-hidden="true"></i>
                <p>
                  Clients
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url('/client/ajouter')?>" class="nav-link <?php $this->rendersection('clientadd') ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ajouter Client</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('/client')?>" class="nav-link <?php $this->rendersection('clientl') ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Liste Des Clients</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('/client/avance')?>" class="nav-link <?php $this->rendersection('avance') ?>">
                    <i class="fa fa-eur nav-icon" aria-hidden="true"></i>
                    <p>Avances Clients</p>
                  </a>
                </li>
              </ul>
            </li>
            
            <li class="nav-item">
              <a href="#" class="nav-link <?php $this->rendersection('commande') ?>">
                <i class="fa fa-shopping-cart nav-icon" aria-hidden="true"></i>
                <p>
                  Commandes
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url('/commande/ajouter')?>" class="nav-link <?php $this->rendersection('commandeadd') ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ajouter Commande</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('/commande')?>" class="nav-link <?php $this->rendersection('commandel') ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Liste Des Commandes</p>
                  </a>
                </li>
              </ul>
            </li>
            <?php if(session('role') == 'assistante commerciale ' || session('role') == 'admin'):?>
              <li class="nav-item">
                <a href="#" class="nav-link <?php $this->rendersection('devis') ?>">
                  <i class="nav-icon fa fa-sticky-note" aria-hidden="true"></i>
                  <p>
                    Devis
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('/devis/ajouter')?>" class="nav-link <?php $this->rendersection('devisadd') ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ajouter Devis</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('/devis')?>" class="nav-link <?php $this->rendersection('devisli') ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Liste Des Devis</p>
                    </a>
                  </li>
                </ul>
              </li>
            <?php endif;?>
            
            <li class="nav-item">
              <a href="#" class="nav-link <?php $this->rendersection('Vente') ?>">
                <i class="fa fa-money nav-icon" aria-hidden="true"></i>
                <p>
                  Ventes
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <?php $var = 0;?>
                <li class="nav-item">
                  <a href="<?= base_url('/Vente/ajouter/'.$var)?>" class="nav-link <?php $this->rendersection('Venteadd') ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ajouter Vente</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('/Vente')?>" class="nav-link <?php $this->rendersection('Ventel') ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Liste Des Ventes</p>
                  </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/facture')?>" class="nav-link <?php $this->rendersection('facturel') ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Liste Des Facture</p>
                    </a>
                  </li>
              </ul>
            </li>
            
            <li class="nav-item">
              <a href="#" class="nav-link <?php $this->rendersection('taches') ?>">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Taches
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge badge-info right"
                  data-toggle="tooltip" data-placement="top" title="Nombre Tâches">
                    <?php $model = new App\Models\Tache;
                      if(session('role') == 'admin'){
                        $totalTachesAujourdhui = $model->countAllResults();
                        echo $totalTachesAujourdhui;
                      }else{
                        $totalTachesAujourdhui = $model->where('id_emp' , session('id_employe'))->countAllResults();
                        echo $totalTachesAujourdhui;
                      }
                    ?>
                  </span>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <?php if(session('role') == 'admin'):?>
                  <li class="nav-item">
                    <a href="<?= base_url('/taches/ajout')?>" class="nav-link <?php $this->rendersection('taches') ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ajouter Tache</p>
                    </a>
                  </li>
                <?php endif;?>
                  <li class="nav-item">
                    <a href="<?= base_url('/taches')?>" class="nav-link <?php $this->rendersection('tachesl') ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Listes Des Taches</p>
                    </a>
                  </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link <?php $this->rendersection('conge') ?>">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                  Congés
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <?php if(session('role') == 'admin'):?>
                  <li class="nav-item">
                    <a href="<?= base_url('/conge/ajouter')?>" class="nav-link <?php $this->rendersection('congeadd') ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ajouter Congé</p>
                    </a>
                  </li>
                <?php endif;?>
                <li class="nav-item">
                  <a href="<?= base_url('/conge')?>" class="nav-link <?php $this->rendersection('congel') ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Liste Des Congés</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link <?php $this->rendersection('rapports') ?>">
                <i class="nav-icon fa fa-bookmark-o" aria-hidden="true"></i>
                <p>
                  Rapports
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url('rapports/chiffres')?>" class="nav-link <?php $this->rendersection('chiffre_daffaires') ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Chiffre d'affaire</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url('rapports/details_commerciaux')?>" class="nav-link <?php $this->rendersection('detail_comm') ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Détails de Commerciaux</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url('rapports/service_vendus')?>" class="nav-link <?php $this->rendersection('service_vendus') ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Rapport Service Vendus</p>
                  </a>
                </li>
              </ul>
            </li>
            
          </ul>
        </nav>
      </div>
    </aside>
    <div class="content-wrapper">
      <?php $this->rendersection("content") ?>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <?php $this->rendersection("script")?>
  <script>
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
      $('#notification').click(function() {
        if (<?= $totalNewNotifications ?> > 0) {
          $.ajax({
            url: '/markNotificationsAsSeen',
            type: 'GET',
            success: function(response) {
              $('#notification-badge').text('').hide();
            },
                error: function(xhr, status, error) {
                  console.log('AJAX Error:', xhr.responseText);
                }
          });
        }
      });
    });
  </script>
  <!-- charts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url('plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- ChartJS -->
<script src="<?= base_url('plugins/chart.js/Chart.min.js') ?>"></script>
<!-- Sparkline -->
<script src="<?= base_url('plugins/sparklines/sparkline.js') ?>"></script>
<!-- JQVMap -->
<script src="<?= base_url('plugins/jqvmap/jquery.vmap.min.js') ?>"></script>
<script src="<?= base_url('plugins/jqvmap/maps/jquery.vmap.usa.js') ?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url('plugins/jquery-knob/jquery.knob.min.js') ?>"></script>
<!-- daterangepicker -->
<script src="<?= base_url('plugins/moment/moment.min.js') ?>"></script>
<script src="<?= base_url('plugins/daterangepicker/daterangepicker.js') ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
<!-- Summernote -->
<script src="<?= base_url('plugins/summernote/summernote-bs4.min.js') ?>"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('dist/js/adminlte.js') ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('dist/js/demo.js') ?>"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')?>"></script>
<script src="<?= base_url('plugins/datatables-responsive/js/dataTables.responsive.min.js')?>"></script>
<script src="<?= base_url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')?>"></script>
<script src="<?= base_url('plugins/datatables-buttons/js/dataTables.buttons.min.js')?>"></script>
<script src="<?= base_url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')?>"></script>
<script src="<?= base_url('plugins/jszip/jszip.min.js')?>"></script>
<script src="<?= base_url('plugins/pdfmake/pdfmake.min.js')?>"></script>
<script src="<?= base_url('plugins/pdfmake/vfs_fonts.js')?>"></script>
<script src="<?= base_url('plugins/datatables-buttons/js/buttons.html5.min.js')?>"></script>
<script src="<?= base_url('plugins/datatables-buttons/js/buttons.print.min.js')?>"></script>
<!-- AdminLTE App -->  <script src="<?= base_url('plugins/select2/js/select2.full.min.js')?>"></script>
<script src="<?= base_url('dist/js/adminlte.min.js')?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('dist/js/demo.js')?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url('dist/js/pages/dashboard.js') ?>"></script>
<script src="https://kit.fontawesome.com/c7dabf0cd3.js" crossorigin="anonymous"></script>
<?php $this->rendersection('fullscript')?>
</body>/
</html>