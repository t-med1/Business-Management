<?php $this->extend('templates/layout') ?>

<?php $this->section("title") ?>
CONGE LIST - PAGE
<?php $this->endsection() ?>

<?php $this->section("congel") ?>
active
<?php $this->endsection() ?>
<?php $this->section("conge") ?>
active
<?php $this->endsection() ?>

<?php $this->section("content") ?>
<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Congés</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('/')?>">Acceuil</a></li>
              <li class="breadcrumb-item active">Congés</li>
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
                        <div class="card-header bg-info mb-2">
                            <h3 class="card-title">Liste Des Congés</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Nom Employé</th>
                                    <th class="bg-info">Janvier</th>
                                    <th class="bg-info">Février</th>
                                    <th class="bg-info">Mars</th>
                                    <th class="bg-info">Avril</th>
                                    <th class="bg-info">Mai</th>
                                    <th class="bg-info">Juin</th>
                                    <th class="bg-info">Juiellet</th>
                                    <th class="bg-info">Août</th>
                                    <th class="bg-info">Septembre</th>
                                    <th class="bg-info">Octobre</th>
                                    <th class="bg-info">Novembre</th>
                                    <th class="bg-info">Décembre</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($groupedConges):?>
                                    <?php foreach ($groupedConges as $employeeId => $conges): ?>
                                        <tr>
                                            <?php $employeeInfo = reset($conges); ?>
                                            <td>
                                                <a href="<?= base_url('Commerciale/details/'.$employeeInfo['id_emp'])?>"
                                                    data-toggle="tooltip" data-placement="top" title="Voir Ce Commercial">
                                                    <strong>
                                                        <?= $employeeInfo['nom'] ?> <?= $employeeInfo['prenom'] ?>
                                                    </strong>
                                                </a>
                                            </td>

                                            <?php for ($month = 1; $month <= 12; $month++): ?>
                                                <td>
                                                    <?php
                                                        $hasConge = false;
                                                        foreach ($conges as $conge) {
                                                            $startDate = new DateTime($conge['date_fin']);
                                                            $startMonth = $startDate->format('n');
                                                            if ($month == $startMonth) {
                                                                $hasConge = true;
                                                                break;
                                                            }
                                                        }
                                                    ?>
                                                    <?php if ($hasConge): ?>
                                                        <i class="fa fa-check" aria-hidden="true"
                                                            style="color: hsl(99, 100%, 65%);"></i>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td>
                                                <div style="display:flex;justify-content:center;gap:5px">

                                                    <a href="<?= base_url('/conge/details/' . $conges[0]['id_conge']) ?>"
                                                        class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="détails">
                                                        <i class="fa fa-list-alt"></i>
                                                    </a>
                                                    <a href="<?= base_url('conge/edit/' . $conges[0]['id_conge']) ?>"
                                                        class="btn btn-success  btn-sm"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Modifier">
                                                        <i class="fa fa-wrench"></i>
                                                    </a>

                                                    <a href="<?= site_url('delete_conge/' . $conges[0]['id_conge']) ?>"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="supprimer" onclick="return confirmSwalDelete(<?= $conges[0]['id_conge'] ?>);"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else :?>
                                    <td colspan="14" style="text-align:center" class="bg-light">
                                        <p>Aucun Congé trouvée...</p>
                                    </td>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        function confirmSwalDelete(id_conge) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: 'Cela va supprimer les congés cet employé !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= site_url('delete_conge/') ?>' + id_conge;
                }
            });
            return false;
        }
        </script>
    </div>

<?php $this->endsection() ?>

<?php $this->section('script')?>
<script>
        const yearSelect = document.getElementById("yearSelect");

        const currentYear = new Date().getFullYear();

        for (let year = currentYear; year >= 1900; year--) {
            const option = document.createElement("option");
            option.value = year;
            option.text = year;
            if (year === currentYear) {
                option.selected = true;
            }

            yearSelect.appendChild(option);
        }
    </script>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#myDiv').slideUp();
            }, 1000);
        });
    </script>
<?php $this->endsection()?>