<?php
$title = 'Daftar Siswa';
include 'views/layout/meta.php';
include 'app/session.php';
include 'Model/StudentsQuery.php';
?>
<style>
    #payment_history {
        background-color: #ffca0d;
        color: #212529;
    }

    .dropdown-item:hover {
        background-color: #d0d5d9;
    }
</style>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include 'views/layout/sidebar.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-md-4" style="margin-bottom: 100px;">
                <div class="d-flex justify-content-between mb-3 mt-3">
                    <a href="index.php?page=tambah_siswa" class="btn btn-success fw-bold"><span class="bi bi-plus">&nbsp;Tambah siswa</span></a>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Semua Kelas
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown">
                                <a href="index.php?page=daftar_siswa" class="btn bg-secondary text-light text-decoration-none mb-3 ms-3" style="width: cover;">Semua siswa</a>
                            </li>
                            <?php
                            $classrooms = $con->query("SELECT * FROM classrooms");
                            $majors = $con->query("SELECT * FROM majors");
                            foreach ($classrooms as $c) :
                            ?>
                                <li class="dropdown">
                                    <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">
                                        <?= $c['classroom'] ?>
                                    </a>
                                    <ul class="dropdown ms-1 p-3">
                                        <?php foreach ($majors as $m) : ?>
                                            <li>
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <input type="text" name="c_id" id="c_id" class="d-none" value="<?= $c['classroom_id'] ?>">
                                                    <input type="text" name="m_id" id="m_id" class="d-none" value="<?= $m['major_id'] ?>">
                                                    <button type="submit" name="classroom" id="classroom" class="badge bg-secondary"><?= $m['major'] ?></button>
                                                </form>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="DataStudents">
                        <thead style="background-color: #ffca0d;">
                            <tr>
                                <th>No.</th>
                                <th>Nis</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>No. Tlp</th>
                                <th>Tahun Ajaran</th>
                                <th class="text-center">Riwayat Transaksi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <?php if (isset($_POST['classroom'])) {
                            include 'views/admin/StudentsofClass.php';
                        } else { ?>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($AllStudentsList as $s) :
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= number_format($s['nis'], 0, ".", ".") ?></td>
                                        <td>
                                            <?php if ($s['photo'] == NULL) : ?>
                                                <img src="public/img/profile.svg" width="50">
                                            <?php else : ?>
                                                <img src="/public/uploaded_img/<?= $s['photo'] ?>" width="50">
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $s['firstname'] . " " . $s['lastname'] ?></td>
                                        <td><?= $s['classroom'] . " " . $s['major'] ?></td>
                                        <td>
                                            <?php
                                            if ($s['tlp'] == NULL) :
                                            ?>
                                                ---
                                            <?php else : ?>
                                                <?= $s['tlp'] ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="d-flex justify-content-center">
                                            <span class="fw-bold me-3"><?= $s['tahun_ajaran'] ?></span>
                                        </td>
                                        <td class="text-center">
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <input type="text" name="student_id" id="student_id" class="d-none" value="<?= $s['student_id'] ?>">
                                                <button type="submit" name="payment_history" id="payment_history" class="btn fw-bold"><span class="bi bi-eye">&nbsp;Lihat</span></button>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#edit<?= $s['student_id'] ?>">
                                                    <span class="bi bi-pen"></span>
                                                </button>
                                                <div class="modal fade" id="edit<?= $s['student_id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit data <?= $s['firstname'] ?></h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <form action="" method="post" enctype="multipart/form-data">
                                                                            <div class="form-group">
                                                                                <label for="fname" class="fw-bold">Nama depan :</label>
                                                                                <input type="text" name="fname" id="fname" class="form-control" value="<?= $s['firstname'] ?>" required>
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <div class="form-group">
                                                                            <label for="lname" class="fw-bold">Nama belakang :</label>
                                                                            <input type="text" name="lname" id="lname" class="form-control" value="<?= $s['lastname'] ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <div class="form-group">
                                                                            <label for="username" class="fw-bold">Username :</label>
                                                                            <input type="text" name="username" id="username" class="form-control" value="<?= $s['username'] ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <div class="form-group">
                                                                            <label for="password" class="fw-bold">Password :</label>
                                                                            <div class="input-group mb-3">
                                                                                <input type="text" name="password" id="password" class="form-control" value="<?= $s['pass'] ?>" required>
                                                                                <input type="radio" class="btn-check" name="show" id="show" autocomplete="off" aria-hidden="true" onclick="toggle()">
                                                                                <label class="btn btn-outline-secondary text-dark" for="show" style="font-size: 25px;"><span class="bi bi-eye"></span></label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <div class="form-group">
                                                                            <label for="classroom" class="fw-bold">Kelas :</label>
                                                                            <select class="form-select" name="classroom" id="classroom" required>
                                                                                <option value="<?= $s['classroom_id'] ?>"><?= $s['classroom'] ?></option>
                                                                                <?php
                                                                                foreach ($ClassroomsQuery as $cr) {
                                                                                    if ($classroom == $cr['classroom_id']) {
                                                                                        $selected = 'selected';
                                                                                    } else {
                                                                                        $selected = '';
                                                                                    }
                                                                                ?>
                                                                                    <option value="<?= $cr['classroom_id'] ?>" <?= $selected ?>> <?= $cr['classroom'] ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <div class="form-group">
                                                                            <label for="major" class="fw-bold">Kelas :</label>
                                                                            <select class="form-select" name="major" id="major" required>
                                                                                <option value="<?= $s['major_id'] ?>"><?= $s['major'] ?></option>
                                                                                <?php
                                                                                foreach ($MajorsQuery as $mj) {
                                                                                    if ($major == $mj['major_id']) {
                                                                                        $selected = 'selected';
                                                                                    } else {
                                                                                        $selected = '';
                                                                                    }
                                                                                ?>
                                                                                    <option value="<?= $mj['major_id'] ?>" <?= $selected ?>> <?= $mj['major'] ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <?php if ($Yearrow > 0) : ?>
                                                                        <div class="col-md-12 mb-3">
                                                                            <div class="form-group">
                                                                                <label for="t_ajaran" class="fw-bold">Tahun ajaran :</label>
                                                                                <select class="form-select" name="t_ajaran" id="t_ajaran" required>
                                                                                    <option value="<?= $s['spp_id'] ?>"><?= $s['tahun_ajaran'] ?></option>
                                                                                    <?php
                                                                                    foreach ($yearQuery as $ta) {
                                                                                        if ($t_ajaran == $ta['spp_id']) {
                                                                                            $selected = 'selected';
                                                                                        } else {
                                                                                            $selected = '';
                                                                                        }
                                                                                    ?>
                                                                                        <option value="<?= $ta['spp_id'] ?>" <?= $selected ?>> <?= $ta['tahun_ajaran'] ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    <?php else : ?>
                                                                        <div class="col-md-6 mb-3">
                                                                            <div class="form-group">
                                                                                <label for="t_ajaran" class="fw-bold">Tahun ajaran :</label>
                                                                                <input type="text" name="t_ajaran" id="t_ajaran" class="form-control" value="<?= $year ?>" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <div class="form-group">
                                                                                <label for="nominal" class="fw-bold">Nominal SPP tahun <?= $year ?>:</label>
                                                                                <input type="number" name="nominal" id="nominal" class="form-control" placeholder="Nominal SPP (Rp. ---.---.---)" required>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="text" name="student_id" id="student_id" class="d-none" value="<?= $s['student_id'] ?>">
                                                                <button type="submit" name="update" class="btn btn-primary"><span class="bi bi-pen">&nbsp;Edit</span></button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#delete<?= $s['student_id'] ?>">
                                                    <span class="bi bi-trash"></span>
                                                </button>
                                                <div class="modal fade" id="delete<?= $s['student_id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h5 class="text-center">Anda yakin untuk menghapus data <?= $s['firstname'] ?>?</h5>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="text" name="student_id" id="student_id" class="d-none" value="<?= $s['student_id'] ?>">
                                                                <button type="submit" name="remove" class="btn btn-danger"><span class="bi bi-trash">&nbsp;Hapus</span></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="text" name="student_id" id="student_id" class="d-none" value="<?= $s['student_id'] ?>">
                                                <button type="submit" name="bayar" id="bayar" class="btn btn-warning fw-bold"><span class="bi bi-cash"></span></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                                ?>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
                <?php if (isset($_SESSION['update']) == 'success') : ?>
                    <script>
                        toastr.success('Transaksi berhasil');
                        toastr.options.progressBar = true;
                    </script>
                <?php
                    unset($_SESSION['update']);
                endif; ?>
                <?php if (isset($_SESSION['pembayaran']) == 'berhasil') : ?>
                    <script>
                        toastr.success('Pembayaran berhasil');
                        toastr.options.progressBar = true;
                    </script>
                <?php
                    unset($_SESSION['pembayaran']);
                endif; ?>
                <?php if (isset($_SESSION['addStudent']) == 'success') : ?>
                    <script>
                        toastr.success('Data berhasil ditambah');
                        toastr.options.progressBar = true;
                    </script>
                <?php
                    unset($_SESSION['addStudent']);
                endif; ?>
                <?php if (isset($_SESSION['editStudent']) == 'success') : ?>
                    <script>
                        toastr.primary('Data berhasil diedit');
                        toastr.options.progressBar = true;
                    </script>
                <?php
                    unset($_SESSION['editStudent']);
                endif; ?>
                <?php if (isset($_SESSION['deleteStudent']) == 'success') : ?>
                    <script>
                        toastr.danger('Data berhasil dihapus');
                        toastr.options.progressBar = true;
                    </script>
                <?php
                    unset($_SESSION['deleteStudent']);
                endif; ?>
            </main>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#DataStudents').DataTable();
        });

        var state = false;

        function toggle() {
            if (state) {
                document.getElementById("password").setAttribute("type", "password");
                document.getElementById("show");
                state = false;
            } else {
                document.getElementById("password").setAttribute("type", "text");
                document.getElementById("show");
                state = true;
            }
        }
    </script>
</body>