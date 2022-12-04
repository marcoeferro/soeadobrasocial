<?php
    include_once("../Entities/User.php");
    include_once("../entities/Farmacia.php");

    $user = new User();
    $user->setWithSession();

    if (!$user->isAuthenticated()) {
        header('Location: index.php');
    }

    if (!$user->isAdmin()) {
        exit("Acceso denegado.");
    }

    $farmacia = Farmacia::getById($user->farmaciaSeleccionada);
?>

<div class="card-primary-title">
    <div class="row">
        <div class="col">
            <h5>Administrar mis Usuarios</h5>
        </div>
    </div>
</div>

<div class="card-body">
    <!-- Formulario para crear nuevo usuario -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card-primary">
                <form action="javascript:;" method="post" onsubmit="newUser()">
                    <div class="card-body">
                        <h6 class="card-title">Nuevo usuario</h6>
                        <p class="card-text">Complete los datos para crear un nuevo usuario.</p>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Nombre de usuario" aria-label="Nombre de usuario" name="username" id="username" maxlength="200" required>
                            </div>
                            <div class="col">
                                <input type="email" class="form-control" placeholder="Email" aria-label="Email" name="email" id="email" maxlength="200" required>
                            </div>
                            <div class="col">
                                <input type="password" class="form-control" placeholder="Contraseña" aria-label="Contraseña" name="password" id="password" maxlength="200" required>
                            </div>
                            <div class="col">
                                <input type="submit" class="button-primary" value="Crear">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card-primary mb-3">
                <div class="card-body">
                    <h6 class="card-title">Mis usuarios</h6>
                        <p class="card-text">Configurar farmacias administrables por usuarios. Solo tú puedes ver esto.</p>
                    <!-- draw table -->
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 7vw;"></th>
                                <th style="width: 15vw;">Usuario</th>
                                <th>Email</th>
                                <th>Farmacias asignadas</th>
                                <th style="width: 8vw;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $users = $user->getUsers();

                                foreach($users as $usr){
                                    ?>
                                        <tr style="border-top: 1px solid #DDDDDD;">
                                            <td><img src="media/<?php echo $usr->imagen ?>" onerror="this.src = 'media/default.png';" class="header-user-icon" alt="logo"></td>
                                            <td><?php echo $usr->username ?></td>
                                            <td><?php echo strtolower($usr->email)?></td>
                                            <td>
                                                <details class="multiple-select">
                                                    <summary onclick="handleMultiselect(this.parentNode)">Ver farmacias asignadas</summary>
                                                    <div class="multiple-select-dropdown">
                                                        <form data-userId="<?php echo $usr->id ?>" action="javascript:;">
                                                            <?php 
                                                            foreach($user->farmacias as $frm){
                                                                $alowed = array_map(function($var){return $var->id ;}, $usr->farmacias);
                                                                $checked = in_array($frm->id, $alowed) ? "checked" : "";
                                                               ?>
                                                                <label>
                                                                    <input type="checkbox" hidden name="select" value="<?php echo $frm->id ?>" <?php echo $checked ?>>
                                                                    <span class="content"><?php echo $frm->nombre ?></span>
                                                                </label>
                                                                <?php
                                                            }
                                                            ?>
                                                            <label>
                                                                <button onclick="multiselectSave(this.closest('form'))" type="submit" class="dropbtn button-secondary size-10">Guardar</button>
                                                            </label>
                                                        </form>
                                                    </div>
                                                </details>
                                            </td>
                                            <td>
                                                <button onclick="changeDeleted(<?php echo $usr->id ?>, 1)" class='btn-circle'><i class='fa-solid fa-trash'></i></button>
                                            </td>
                                        </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>