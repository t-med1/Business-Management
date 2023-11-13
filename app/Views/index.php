<?php $this->extend('templates/layout') ?>

<?php $this->section('title') ?>
TABLEAU DE BORD - PAGE
<?php $this->endsection() ?>

<?php $this->section('content') ?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Tableau De Bord</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
          <li class="breadcrumb-item active">Tableau De Bord</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>
                <?= $totalClient ?>
              </h3>

              <p><b>Liste Clients</b></p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?= base_url('/client')?>" class="small-box-footer">Plus D'infos <i class="fas fa-arrow-circle-right"></i></a>
          </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>
              <?= $totalCommandes ?>
            </h3>
            <p><b>Liste Des Commandes</b></p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="<?= base_url('/commande')?>" class="small-box-footer">Plus D'infos <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <div style="display:flex;gap:30px;">
              <h3>
                <?= $totalTachesAujourdhui ?>
              </h3>
              <span style="font-size: 16px; font-weight:5px;color:#B5F2E5">Ajourdhui</span>
            </div>
            <p><b>Liste Des Taches</b></p>
          </div>
          <div class="icon">
            <i class="fas fa-barcode"></i>
          </div>
          <a href="<?= base_url('/taches')?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= $chiffreAffairesHT ?> DH</h3>

              <p><b>Chiffre D'affaires</b></p>
            </div>
            <div class="icon">
              <i class="fa fa-dollar"></i>
            </div>
            <a href="#" class="small-box-footer">
              <b id="currentMonthYear"></b>
            </a>
          </div>
        </div>
    </div>

    <?php if (session('role') != 'admin'): ?>
      <div class="row">
        <?php
        $notificationModel = new App\Models\Notification;
        $notifications = $notificationModel->where('id_emp', session('id_employe'))->where('showin', 'unseen')->findAll();
        $totalNewNotifications = $notificationModel->where('id_emp', session('id_employe'))->where('showin', 'unseen')->countAllResults();
        if ($totalNewNotifications > 0) {
          ?>
          <div class="alert alert-warning alert-dismissible col-md-12">

            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5 style="display:flex;justify-content:space-between;">
              <span><i class="fa fa-exclamation" aria-hidden="true"></i> Tâches</span>
              <?php
                $currentDateTime = new DateTime();
                foreach ($notifications as $notification) {
                  $createdAt = new DateTime($notification['created_at']);
                  $interval = $currentDateTime->diff($createdAt);
                  echo '<div style="font-size:16px">' . formatTimeDifference($interval) . '</div>';
                }
              ?>
            </h5>
            <a href="/markNotificationsAsSeen" id="popoverOption" class="btn"
              style="font-weight:bold;vertical-align: baseline !important" data-content="<b>TACHE</b><br>" rel="popover"
              data-placement="top" data-toggle="tooltip" title="Voir Les Tâches">
              <?php if ($totalNewNotifications > 1): ?>
                Vous avez &nbsp;<b>
                  <?= $totalNewNotifications ?>
                </b>&nbsp; Nouvelles tâches ont été créées.
              <?php elseif ($totalNewNotifications == 1): ?>
                Vous avez &nbsp;<b>
                  <?= $totalNewNotifications ?>
                </b>&nbsp; Nouvelle tâche a été créée.
              <?php endif; ?>
            </a>
          </div>
        <?php } ?>
      </div>
    <?php endif; ?>
    <?php if (session('role') == 'admin'): ?>
      <?php
      $tacheModel = new App\Models\Tache;
      $venteModel = new App\Models\Vente;
      $taches = $tacheModel->first();

      $currentDate = date('Y-m-d');
      $chequeTotal = $venteModel
          ->where('mode_paiement', 'cheque')
          ->where('montant_rest > ' , 0 )
          ->where('date_cheque <', $currentDate)
          ->countAllResults();
      $cheque = $venteModel
          ->where('mode_paiement', 'cheque')
          ->where('montant_rest > ' , 0 )
          ->where('date_cheque <=', $currentDate)
          ->first();
          // print_r($cheque);die();
      $tachesEnretard = $tacheModel->where('statut' , 'en retard')->first();
      $totalTachesRetards = $tacheModel->where('statut', 'en retard')->countAllResults();
      ?>
      <?php if( $tachesEnretard ):?>
      <div class="row">
        <div class="alert alert-danger alert-dismissible col-md-12">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5 style="display:flex;justify-content:space-between;">
            <span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Tâches En Retards</span>
            <?php
            $currentDateTime = new DateTime();
            // foreach ($taches as $tache) {
              $createdAt = new DateTime($taches['date_fin']);
              $interval = $currentDateTime->diff($createdAt);
              echo '<div style="font-size:16px">' . formatTimeDifference($interval) . '</div>';
            // }
            ?>
          </h5>
          <a  href="<?= base_url('/taches')?>" id="popoverOption"
              class="btn"
              style="font-weight:bold;vertical-align: baseline !important"
              data-toggle="tooltip" data-placement="top" title="Voir Tache">
            <?php if ($totalTachesRetards > 1): ?>
              <span>Vous avez &nbsp;<b>
                <?= $totalTachesRetards ?>
              </b>&nbsp; tâches en retard.</span>
            <?php elseif ($totalTachesRetards == 1): ?>
              <span>Vous avez &nbsp;<b>
                <?= $totalTachesRetards ?>
              </b>&nbsp; tâche en retard.</span>
            <?php endif; ?>
          </a>
        </div>
      </div>
      <?php endif;?>

      <?php if( $chequeTotal > 0 ):?>
        <div class="row">
        <div class="alert alert-danger alert-dismissible col-md-12">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5 style="display:flex;justify-content:space-between;">
            <span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Chèque à en caissé</span>
            <?php
            $currentDateTime = new DateTime();
            // foreach ($taches as $tache) {
              $createdAt = new DateTime($cheque['created_at']);
              $interval = $currentDateTime->diff($createdAt);
              echo '<div style="font-size:16px">' . formatTimeDifference($interval) . '</div>';
            // }
            ?>
          </h5>
          <a  href="<?= base_url('/Vente')?>" id="popoverOption"
              class="btn"
              style="font-weight:bold;vertical-align: baseline !important"
              data-toggle="tooltip" data-placement="top" title="Voir Chèque">
            <?php if ($chequeTotal > 1): ?>
              <span>Vous avez &nbsp;<b>
                <?= $chequeTotal ?>
              </b>&nbsp; Chèques à en caissés.</span>
            <?php elseif ($chequeTotal == 1): ?>
              <span>Vous avez &nbsp;<b>
                <?= $chequeTotal ?>
              </b>&nbsp; Chèque à en caissé.</span>
            <?php endif; ?>
          </a>
        </div>
      </div>
      <?php endif;?>
    <?php elseif(session('role') != 'admin'):?>
      <?php
      $tacheModel = new App\Models\Tache;
      $taches = $tacheModel->where('id_emp', session('id_employe'))->first();
      $tachesEnretard = $tacheModel->where('statut' , 'en retard')->where('id_emp', session('id_employe'))->first();
      $totalTachesRetards = $tacheModel->where('id_emp', session('id_employe'))->countAllResults();
      if($tachesEnretard){
      ?>
      <div class="row">
        <div class="alert alert-danger alert-dismissible col-md-12">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5 style="display:flex;justify-content:space-between;">
            <span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Tâches En Retards</span>
            <?php
              $currentDateTime = new DateTime();
                $createdAt = new DateTime($taches['date_fin']);
                $interval = $currentDateTime->diff($createdAt);
                echo '<div style="font-size:16px">' . formatTimeDifference($interval) . '</div>';
            ?>
          </h5>
          <a  href="/taches" id="popoverOption"
              class="btn"
              style="font-weight:bold;vertical-align: baseline !important"
              data-toggle="tooltip" data-placement="top" title="Voir Tâches">
            <?php if ($totalTachesRetards > 1): ?>
              <span>Vous avez &nbsp;<b>
                <?= $totalTachesRetards ?>
              </b>&nbsp; tâches en retard.</span>
            <?php elseif ($totalTachesRetards == 1): ?>
              <span>Vous avez &nbsp;<b>
                <?= $totalTachesRetards ?>
              </b>&nbsp; tâche en retard.</span>
            <?php endif; ?>
          </a>
        </div>
      </div>
      <?php }?>
    <?php endif; ?>
    <?php
    function formatTimeDifference($interval)
    {
      $output = '';
      if ($interval->y > 0) {
        $output .= 'il y a ' . $interval->format('%y Année ');
      } elseif ($interval->m > 0) {
        $output .= 'il y a ' . $interval->format('%m mois ');
      } elseif ($interval->d > 0) {
        $output .= 'il y a ' . $interval->format('%d jours ');
      } elseif ($interval->h > 0) {
        $output .= 'il y a ' . $interval->format('%h heurs ');
      } elseif ($interval->i > 0) {
        $output .= 'il y a ' . $interval->format('%i minutes ');
      } else {
        $output .= "à l'instant";
      }
      return $output;
    }
    ?>
<div class="row">
  <div class="col-md-6">
    <div class="card card-info">
      <div class="card-header with-border">
        <h3 class="card-title">Nombre de Ventes</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12 table-responsive">
            <div class="chart tab-pane active" id="revenue-chart-1" style="position: relative; height: 300px;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card card-info">
      <div class="card-header with-border">
        <h3 class="card-title">Chiffre d'affaires TTC</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12 table-responsive">
            <div class="chart tab-pane active" id="revenue-chart-2" style="position: relative; height: 300px;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row mb-5">
  <?php
    $venteModel = new App\Models\Vente;
    $currentDat = date('Y-m-d');
    $totalVenteAuj = $venteModel->where('created_at' , $currentDat )->countAllResults();
    $chiffreAffairesTTC = 0;
    foreach ($venteModel->where( 'created_at' , $currentDat )->findAll() as $vente) {
      $chiffreAffairesTTC += $vente['total_ttc'];
    }
  ?>
    <div class="col-md-6 text-light">
        <div class="callout callout-info" style="margin-bottom: 0px; background-color: #3d9dcd !important; border-color: #1f6e87; !important;">
                        <p>Nombre de Ventes d'Aujourd'hui :</p>
            <h4 style="margin: 10px 0px 5px 0px;">
              <span id="nbr_ventes_today"><?= $totalVenteAuj ?></span>
            </h4>
        </div>
    </div>
    <div class="col-md-6 text-light">
        <div class="callout callout-info" style="margin-bottom: 0px; background-color: #3dbc7b !important; border-color: #318752; !important;">
                        <p>Chiffre d'affaires TTC d'Aujourd'hui :</p>
            <h4 style="margin: 10px 0px 5px 0px;">
              <span id="ca_ttc_today"><?= $chiffreAffairesTTC ?></span> <small style="color: white;">DH</small>
            </h4>
        </div>
    </div>
</div>
</section>
<?php $this->endsection() ?>

<?php $this->section("script")?>
<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var area_1 = new Morris.Area({
            element: 'revenue-chart-1',
            resize: true,
            parseTime: false,
            xLabelAngle: -50,
            gridIntegers: true,
            data: <?php echo json_encode($ventesData); ?>,
            xkey: 'y',
            ykeys: ['nombre_ventes'],
            labels: ['Nombre de Ventes'],
            lineColors: ['#3c8dbc'],
            yLabelFormat: function (y) { return y != Math.round(y) ? '' : y; },
            hideHover: 'auto'
        });
    // ----------------------------------------------------------------------------
    var area_2 = new Morris.Area({
            element: 'revenue-chart-2',
            resize: true,
            parseTime: false,
            xLabelAngle: -50,
            data: <?php echo json_encode($ventesTotalData); ?>,
            xkey: 'y',
            ykeys: ['total_ventes'],
            labels: ['Chiffre d\'affaires TTC'],
            lineColors: ['#3dbc7b'],
            hideHover: 'auto'
        });
  });
</script>
<script>
        // Define an array of month names in French
        const monthsInFrench = [
            "Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
            "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"
        ];

        // Get the current date
        const currentDate = new Date();

        // Extract the month and year
        const currentMonth = monthsInFrench[currentDate.getMonth()];
        const currentYear = currentDate.getFullYear();

        // Create the desired format
        const currentMonthYearInFrench = `${currentMonth} ${currentYear}`;

        // Display the result in the specified element
        document.getElementById("currentMonthYear").textContent = currentMonthYearInFrench;
    </script>
<?php $this->endsection()?>