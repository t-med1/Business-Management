<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
DETAIL TACHE - PAGE
<?php $this->endsection() ?>

<?php $this->section("taches") ?>
active
<?php $this->endsection() ?>

<?php $this->section("content") ?>
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tâches</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
              <li class="breadcrumb-item active">Sous Tâches</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<?php $successFlash = session()->getFlashdata('success'); ?>
<?php if (isset($successFlash)): ?>
    <div class="row" class="myDiv">
        <div class="alert alert-success">
            <?= $successFlash ?>
        </div>
    </div>
<?php endif; ?>
<?php $errorFlash = session()->getFlashdata('error'); ?>
<?php if (isset($errorFlash)): ?>
    <div class="row" class="myDiv">
        <div class="alert alert-danger">
            <?= $errorFlash ?>
        </div>
    </div>
<?php endif; ?>
<section class="content ml-3">
<div class="row d-flex" style="gap:20px">
    <div class="card card-solid col-md-4">
        <div class="card-body pb-0">
            <div class="row">
                <div class="d-flex align-items-stretch flex-column col-md-12">
                    <div class="card bg-light d-flex flex-fill">
                        <div class="card-header text-muted border-bottom-0">
                        <i class="fa fa-eercast" aria-hidden="true"></i> Commerciale
                        </div>
                        <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-7">
                            <h2 class="lead"><b style="color:green; font-weight:bold;"><?= $employee["nom"]?> <?= $employee['prenom']?></b></h2>
                            <p class="text-muted text-sm"><b>Role: </b> <?= $employee['role']?></p>
                            <p class="text-muted text-sm"><b>Date Début: </b> <?= $tache['date_debutT']?></p>
                            <p class="text-muted text-sm"><b>Date Fin: </b> <?= $tache['date_fin']?></p>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Email : <?= $employee['email']?></li><br>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Téléphone : <?= $employee['telephone']?></li>
                            </ul>
                            </div>
                        </div>
                        </div>
                        <div class="card-footer">
                        <div class="text-right">
                            <a href="#" class="btn btn-sm bg-teal" hidden>
                                <i class="fas fa-comments"></i>
                            </a>
                            <?php if(session('id_employe') == $employee['id_emp']) :?>
                                <a href="<?= base_url('profile/'.$employee['id_emp'])?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-user"></i> Voir Profile
                                </a>
                            <?php endif;?>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card col-md-7">
        <div class="card-header bg-info">
            <h3 class="card-title">Liste Des Sous Tâches</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <?php if(session('role') == 'gestionnaire' ):?>
                <div class="row justify-content-end mb-3">
                    <button id="ajoute" href="#" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Ajouter Sous Tache
                    </button>
                </div>
            <?php endif; ?>
            <table id="example1" class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>Num Sous Tâche</th>
                        <th>Date Début</th>
                        <th>Date Fin</th>
                        <th>Description</th>
                        <th>Etat</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($listes_souT): ?>
                        <?php foreach ($listes_souT as $list): ?>
                            <tr>
                                <td>
                                    <?= $list["id_sou_tache"] ?>
                                </td>
                                <td>
                                    <?= $list["date_debut"]; ?>
                                </td>
                                <td>
                                    <?= $list["date_fin"]; ?>
                                </td>
                                <td>
                                    <?= $list["description"]; ?>
                                </td>
                                <td>
                                    <?php if ($list['statut'] == "en cours"): ?>
                                        <form
                                            action="<?= base_url('SouTacheController/updateStatut/' . $list["id_sou_tache"] . '/' . $list['id_tache']) ?>">
                                            <button class="btn btn-warning btn-icon-text btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="En Cours"
                                                <?= session('id_employe') != $employee['id_emp'] ? 'disabled' : '' ?>>
                                                En cours
                                                <i class="fa fa-spinner" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    <?php elseif ($list['statut'] == "en attente"): ?>
                                        <form
                                            action="<?= base_url('SouTacheController/updateStatut/' . $list["id_sou_tache"] . '/' . $list['id_tache']) ?>">
                                            <button class="btn btn-dark btn-icon-text btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="en attente">
                                                <?= session('id_employe') != $employee['id_emp'] ? 'disabled' : '' ?>
                                                To Do
                                                <i class="fa fa-folder" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    <?php elseif ($list['statut'] == "terminée"): ?>
                                        <form
                                            action="<?= base_url('SouTacheController/updateStatut/' . $list["id_sou_tache"] . '/' . $list['id_tache']) ?>">
                                            <button class="btn btn-success btn-icon-text btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="Términé"
                                                <?= session('id_employe') != $employee['id_emp'] ? 'disabled' : '' ?> disabled>
                                                Done
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    <?php elseif ($list['statut'] == "en retard"): ?>
                                        <form
                                            action="<?= base_url('SouTacheController/updateStatut/' . $list["id_sou_tache"] . '/' . $list['id_tache']) ?>">
                                            <button class="btn btn-danger btn-icon-text btn-sm"
                                                <?= session('id_employe') != $employee['id_emp'] ? 'disabled' : '' ?>>
                                                Retard
                                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('delete_souT/' . $list['id_sou_tache']) ?>"
                                        class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"
                                        title="Supprimer" onclick="return confirmSwalDelete(<?= $list['id_sou_tache'] ?>);">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <td colspan="6" style="text-align:center" class="bg-light">
                            <p>Aucune sous tache trouvée...</p>
                        </td>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</section>
<?php if( session('role') == 'gestionnaire' ):?>
    <section class="content" id="card">
    <!-- general form elements disabled -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Ajouter Sous Tâches</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form method="post" action="<?= base_url('/taches/save/'.$tache['id_tache'])?>">
                <?= csrf_field() ?>
                <input type="hidden" name="id_tache" value="<?= $tache['id_tache'] ?>">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Date Début<span class="text-danger">*</span> :</label>
                            <input class="form-control" type="date" name="date_debut" id="date_debutT" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Date Fin<span class="text-danger">*</span> :</label>
                            <input class="form-control" type="date" name="date_fin" id="date_fin" required>
                            <p id="p" class='text-danger'></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Description<span class="text-danger">*</span> :</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name='description'
                                required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row" style="display:flex; justify-content:center;gap:20px">
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-outline-info btn-block btn-flat" style="border-radius:10px;"><i
                                class="fa fa-save"></i> Enregistrer</button>
                    </div>
                    <div class="col-sm-2">
                        <button id="cancel" type="button" class="btn btn-outline-danger btn-block btn-flat" style="border-radius:10px;"><i
                                class="fa fa-cancel"></i> Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </section>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmSwalDelete(id_sou_tache) {
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: 'Cela va supprimer cet employé et ses tâches et congés associés !',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimer'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= site_url('delete_souT/') ?>' + id_sou_tache;
            }
        });
        return false;
    }

    $(document).ready(function () {
        $('#card').hide();
        $('#ajoute').on('click' , function(){
            $('#card, #cancel').css({ 'display': 'block', 'opacity': 0 }).animate({ 'opacity': 1, 'transform': 'translateY(0)' }, 500);
            $('#ajoute').hide('hide');
        });

        $('#cancel').on('click' , function(){
            $('#card, #cancel').animate({ 'opacity': 0, 'transform': 'translateY(-10px)' }, 500, function() {
                $(this).css('display', 'none');
            });
            $('#ajoute').show('hide');
        });

        $('#date_fin').on('change', function () {
            var dateDebut = new Date($('#date_debutT').val());
            var dateFin = new Date($('#date_fin').val());

            if (dateDebut > dateFin) {
                $('#date_fin').removeClass('is-valid');
                $('#date_fin').addClass('is-invalid');
                $('#p').html('la date Début est supérieur à la date fin')
            } else {
                $('#date_fin').removeClass('is-invalid');
                $('#date_fin').addClass('is-valid');
                $('#p').html('')
            }
        });
    });

    $(document).ready(function () {
        // Function to remove the div elements after 2 seconds
        function removeDivs() {
            $(".myDiv").fadeOut(2000, function () {
                $(this).remove();
            });
        }

        <?php if (isset($successFlash) || isset($errorFlash)): ?>
        // Call the function to remove divs if they exist
        removeDivs();
        <?php endif; ?>
    });
</script>

<?php $this->endsection() ?>