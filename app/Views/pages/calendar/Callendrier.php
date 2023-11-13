<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
CLENDRIER - PAGE
<?php $this->endsection() ?>

<?php $this->section("calendrier") ?>
active
<?php $this->endsection() ?>

<?php $this->section("full") ?>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.css' rel='stylesheet' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css' rel='stylesheet' />
<?php $this->endsection() ?>

<?php $this->section("fullscript") ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
<?php $this->endsection() ?>

<?php $this->section("content") ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Calendrier</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
                    <li class="breadcrumb-item active">Calendrier</li>
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
    <script>
        location.reload();
    </script>
    <div class="row" id="myDiv">
        <div class="alert alert-danger">
            <?= $errorFlash ?>
        </div>
    </div>
<?php endif; ?>
<section class="content">
    <div class="row">
            <div class="alert alert-danger" id="div" hidden>
            </div>
    </div>
</section>
<section class="content">
    <!-- general form elements disabled -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Calendrier</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
</section>
<?php $this->endsection() ?>
<?php $this->section("script") ?>
<script>
    $(document).ready(function () {
        var calendar = $('#calendar').fullCalendar({
            plugins: ['dayGrid', 'timeGrid', 'list', 'interaction'],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            initialView: 'dayGridMonth',
            locale: 'fr',
            events: "<?php echo base_url(); ?>fullcalendar/load",
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay) {
                var title = prompt("Entrez le titre de l'événement");
                if (title) {
                    var start = moment(start).format("YYYY-MM-DDTHH:mm:ss");
                    var end = moment(end).format("YYYY-MM-DDTHH:mm:ss");
                    
                    <?php if (session('role') == 'gestionnaire'): ?>
                        var DivElement = document.getElementById('div');
                        DivElement.innerHTML = "Tu n'est pas le droit de créer un calendrier";
                        DivElement.removeAttribute('hidden');
                        setTimeout(function() {
                            $('#div').slideUp();
                        }, 2000);
                    <?php else: ?>
                        $.ajax({
                            url: "<?php echo base_url('FullCalendarController/create'); ?>",
                            type: "POST",
                            data: {
                                title: title,
                                start: start,
                                end: end,
                                csrf_test_name: '<?= csrf_hash() ?>'
                            },
                            success: function (data) {
                                calendar.fullCalendar('renderEvent', {
                                    id: data.id_calendar,
                                    title: data.titre,
                                    start: data.start_event,
                                    end: data.end_event,
                                }, true);
                                calendar.fullCalendar('unselect');
                                location.reload();
                            },
                            error: function () {
                                var DivElement = document.getElementById('div');
                                DivElement.removeAttribute('hidden');
                                DivElement.innerHTML = "Tu n'est pas le droit de créer un événement";
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }
                        });
                    <?php endif; ?>
                }
            },
            editable: true,

            eventDrop: function (event) {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                var title = event.title;
                <?php if (session('role') == 'gestionnaire'): ?>
                        var DivElement = document.getElementById('div');
                        DivElement.innerHTML = "Tu n'est pas le droit de modifier un événement";
                        DivElement.removeAttribute('hidden');
                        setTimeout(function() {
                            $('#div').slideUp();
                        }, 2000);
                <?php else: ?>
                    $.ajax({
                        url: "FullCalendarController/update/" + event.id_calendar,
                        type: "POST",
                        data: { 
                            title: title, 
                            start: start, 
                            end: end, 
                            id: event.id_calendar,
                            csrf_test_name: '<?= csrf_hash() ?>' 
                        },
                        success: function () {
                            calendar.fullCalendar('refetchEvents');
                            alert("Événement mis à jour");
                            location.reload();
                        },
                        error: function () {
                            var DivElement = document.getElementById('div')
                            DivElement.removeAttribute('hidden');
                            DivElement.innerHTML = "Tu n'est pas le droit de modifier Un Calendrier";
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    })
                <?php endif;?>
            },
            eventClick: function (event) {
                if (confirm("Êtes-vous sûr de vouloir le supprimer ?")) {
                    
                    $.ajax({
                        url: "<?php echo base_url('FullCalendarController/delete/'); ?>" + event.id_calendar,
                        type: "POST",
                        data: {
                            id_calendar: event.id_calendar,
                            csrf_test_name: '<?= csrf_hash() ?>' 
                        },
                        success: function (data) {
                            if (data.status === 'success') {
                                calendar.fullCalendar('removeEvent', event.id);
                                alert('Événement supprimé');
                                location.reload();
                            } else {
                                alert('Error deleting event.');
                            }
                        },
                        error: function () {
                            var DivElement = document.getElementById('div')
                            DivElement.removeAttribute('hidden');
                            DivElement.innerHTML = "Tu n'est pas le droit de Supprimer Un Calendrier";
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    });
                };
            }
        });
    });

</script>
<?php $this->endsection() ?>