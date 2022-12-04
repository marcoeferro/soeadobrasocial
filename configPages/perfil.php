<?php
    include_once("../Entities/User.php");
    include_once("../entities/Farmacia.php");

    $user = new User();
    $user->setWithSession();

?>

<div class="card-primary-title">
    <div class="row">
        <div class="col">
            <h5>Datos del Perfil</h5>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col">
            <div class="card-primary mb-3">
                <div class="card-body">
                    <div class="row profile">
                        <div class="mb-3">
                            <h6 class="card-title">Cambiar imagen de Perfil.</h6>
                            <p class="card-text">Utiliza una imagen para identificar tu Perfil.</p>
                            <div class="editar-perfil mb-2">
                                <img id = "userImg" src="media/<?php echo $user->imagen ?>" onerror="this.src = 'media/default.png';" alt="user-image">
                                <a onclick="selectFile()" href="javascript:;" class="editar-imagen"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <input id="imageInput" type="file" name="image" accept="image/*" hidden />
                            </div>
                            <h5>Usuario: <?php echo $user->username ?></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-primary mb-0">
                <div class="card-body">
                    <form action="javascript:;" method="post" onsubmit="updatePassword()">
                        <h6 class="card-title">Cambiar contraseña</h6>
                        <p class="card-text">Modifica tu contraseña. Tendrás que volver a iniciar sesión.</p>
                        <label for="pass">Contraseña anterior</label>
                        <input type="password" id="oldPassword" name="pass" placeholder="Contraseña" class="mb-4">
                        <label for="pass">Contraseña nueva</label>
                        <input type="password" id="newPassword" name="pass" placeholder="Contraseña" class="mb-4">
                        <label for="pass">Repita la contraseña </label>
                        <input type="password" id="confirmPassword" name="pass" placeholder="Contraseña" class="mb-4">
                        <button type="submit" class="dropbtn button-secondary size-10">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card-primary mb-3">
                <div class="card-body">
                    <h6 class="card-title">Ajustes de la cuenta</h6>
                    <p class="card-text">Puedes utilizar estos datos para iniciar sesión.</p>
                    <form action="javascript:;" method="post" onsubmit="updateUsername()">
                        <label for="correo">Correo electrónico</label>
                        <input value="<?php echo $user->email ?>" type="email" id="correo" name="correo" placeholder="Correo" class="mb-4" disabled>
                        <label for="alias">Alias</label>
                        <input value="<?php echo $user->username ?>" type="text" id="alias" name="alias" placeholder="Designa un alias" class="mb-4" required>
                        <button type="submit" class="dropbtn button-secondary size-10">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>