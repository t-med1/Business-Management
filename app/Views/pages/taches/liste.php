<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
LISTE TACHES - PAGE
<?php $this->endsection() ?>
<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
<?php $this->endsection() ?>
<?php $this->section("tachesl") ?>
active
<?php $this->endsection() ?>
<?php $this->section("taches") ?>
active
<?php $this->endsection() ?>

<?php $this->section("content") ?>
<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tâches</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
              <li class="breadcrumb-item active">Tâches</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<?php $successFlash = session()->getFlashdata('success'); ?>
<?php if (isset($successFlash)): ?>
    <div class="row" id="myDiv">
        <div class="alert alert-success">
            <?= $successFlash ?>
        </div>
    </div>
<?php endif; ?>
<?php $errorFlash = session()->getFlashdata('error'); ?>
<?php if (isset($errorFlash)): ?>
    <div class="row" id="myDiv">
        <div class="alert alert-danger">
            <?= $errorFlash ?>
        </div>
    </div>
<?php endif; ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title">Liste Des Tâches pour chaque Commerciale</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>Employé</th>
                                        <th>Date Début</th>
                                        <th>Date Fin</th>
                                        <th>Description</th>
                                        <th>Etat</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($listes_t): ?>
                                        <?php foreach ($listes_t as $taches): ?>
                                            <tr>
                                                <td>
                                                    <a href="/employe/details/<?= $taches['id_emp'] ?>"class="badge <?= $taches['role'] == 'admin' ? 'bg-success' : 'bg-warning' ?> custom-tooltip"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="<?= $taches['role'] ?>">
                                                        <?= $taches['nom'] ?> <?= $taches['prenom'] ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?= $taches['date_debutT'] ?>
                                                </td>
                                                <td>
                                                    <?= $taches['date_fin'] ?>
                                                </td>
                                                <td>
                                                    <?= $taches['description'] ?>
                                                </td>
                                                <td>

                                                    <?php if ($taches['statut'] == "en cours"): ?>
                                                        <form
                                                            action="<?= base_url('TacheController/updateStatut/' . $taches["id_tache"]) ?>">
                                                            <button class="btn btn-warning btn-icon-text btn-sm" data-toggle="tooltip"
                                                                data-placement="top" title="En Cours"
                                                                <?= session('id_employe') == $taches['id_emp'] ? '' : 'disabled' ?>>
                                                                En cours
                                                                <i class="fa fa-spinner" aria-hidden="true"></i>
                                                            </button>
                                                        </form>
                                                    <?php elseif ($taches['statut'] == "en attente"): ?>
                                                        <form
                                                            action="<?= base_url('TacheController/updateStatut/' . $taches["id_tache"]) ?>">
                                                            <button class="btn btn-dark btn-icon-text btn-sm" data-toggle="tooltip"
                                                                data-placement="top" title="en attente"
                                                                <?= session('id_employe') == $taches['id_emp'] ? '' : 'disabled' ?>>
                                                                A Faire
                                                                <i class="fa fa-folder" aria-hidden="true"></i>
                                                            </button>
                                                        </form>
                                                    <?php elseif ($taches['statut'] == "terminée"): ?>
                                                        <form
                                                            action="<?= base_url('TacheController/updateStatut/' . $taches["id_tache"]) ?>">
                                                            <button class="btn btn-success btn-icon-text btn-sm" data-toggle="tooltip"
                                                                data-placement="top" title="Términé"
                                                                <?= session('id_employe') == $taches['id_emp'] ? '' : 'disabled' ?> disabled>
                                                                Terminée
                                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                            </button>
                                                        </form>
                                                    <?php elseif ($taches['statut'] == "en retard"): ?>
                                                        <form action="<?= base_url('TacheController/updateStatut/' . $taches["id_tache"]) ?>" method="get">
                                                            <button type="submit" class="btn btn-danger btn-icon-text btn-sm" data-toggle="tooltip"
                                                                    data-placement="top" title="Mettre à jour les retards"
                                                                    <?= session('id_employe') == $taches['id_emp'] ? '' : 'disabled' ?>>
                                                                    En retard
                                                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                                            </button>
                                                        </form>
                                                        
                                                    <?php endif; ?>
                                                    
                                                </td>
                                                <td>
                                                    <div class="btn-container" style="display:flex;justify-content:center;gap:5px">
                                                        <a href="<?= base_url('/taches/details/' . $taches['id_tache']) ?>"
                                                            class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="Détails">
                                                            <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                        </a>
                                                        <?php if(session('role') == 'admin' || session('id_employe') == $taches['id_emp']):?>
                                                            <a href="<?= base_url('/taches/edit/' . $taches['id_tache']) ?>"
                                                                class="btn btn-success btn-sm" data-toggle="tooltip"
                                                                data-placement="top" title="Modifier">
                                                                <i class="fa fa-wrench" aria-hidden="true"></i>
                                                            </a>
                                                        <?php endif;?>
                                                        <?php if(session('role') == 'admin'):?>
                                                            <a href="taches/delete/<?= $taches['id_tache'] ?>"
                                                                class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"
                                                                title="Supprimer"onclick="return confirmSwalDelete(<?= $taches['id_tache'] ?>);">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </a>
                                                        <?php endif;?>
                                                    </div>
                                                    </th>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <td colspan="6" style="text-align:center" class="bg-light">
                                            <p>Aucune tache trouvée...</p>
                                        </td>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function confirmSwalDelete(id_tache) {
    Swal.fire({
        title: 'Êtes-vous sûr?',
        text: 'Cela va supprimer cet employé et ses tâches et congés associés !',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimer'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= site_url('taches/delete/') ?>' + id_tache;
        }
    });
    return false;
}
</script>
<?php $this->endsection() ?>
<?php $this->section("script")?>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });
</script>
<?php $this->endsection()?>