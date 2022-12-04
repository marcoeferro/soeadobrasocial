var modal = new bootstrap.Modal(document.getElementById("modalCenprofar"), {
    keyboard: false,
  });

  var modalTitle = document.getElementById("modalTitle");
  var modalContent = document.getElementById("modalContent");
  var btnCerrar = document.getElementById("btnCerrarModal");
  var btnCerrarX = document.getElementById("btnCerrarModalX");

  btnCerrar.addEventListener("click", function () {
    modalTitle.innerHTML = "";
    modalContent.innerHTML = "";
    modal.hide();
  });

  btnCerrarX.addEventListener("click", function () {
    modalTitle.innerHTML = "";
    modalContent.innerHTML = "";
    modal.hide();
  });

sections = document.querySelectorAll(".list-group-item")
sections.forEach(section => {
    section.addEventListener("click", function () {
        document.querySelector("#panel-content").innerHTML = `
            <div class="d-flex align-items-center m-4">
                <p>Loading...</p>
                <div class="spinner-border spinner-border-sm text-secondary ms-auto" role="status" aria-hidden="true"></div>
            </div>
        `;
        prevActive = document.querySelector(".list-ajustes-active")
        if (prevActive) {
            prevActive.classList.remove("list-ajustes-active")
            prevActive.classList.add("list-ajustes-item")
        }
        section.classList.remove("list-ajustes-item")
        section.classList.add("list-ajustes-active")
        fetch(`${section.getAttribute("data-panel")}`).then(response => {
            return response.text();
        }).then(html => {
            document.querySelector("#panel-content").innerHTML = html;
        })
    });
})
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const option = urlParams.get("option") == null ? 0 : urlParams.get("option");
if (sections.length > 0){
    sections[option].click()
}

/* ------------AJUSTES DE PERFIL-------------- */

function updateUsername(){
    $('#page-loader').show();
    var username = $("#alias").val();
    $.ajax({
        url: "api/updateUsername.php",
        type: "POST",
        data: {
            username: username
        },
        success: function(response) {
            $('#page-loader').fadeOut(500);
            if (response == '1'){
                modalTitle.innerHTML = "Usuario Actualizado";
                modalContent.innerHTML = "El nombre de usuario ha sido actualizado correctamente.";
            }else{
                modalTitle.innerHTML = "Error";
                modalContent.innerHTML = response;
            }
            modal.show();
        }
    });
}

function updatePassword(){
    $('#page-loader').show();

    var oldPassword = $("#oldPassword").val();
    var newPassword = $("#newPassword").val();
    var confirmPassword = $("#confirmPassword").val();
    if (newPassword != confirmPassword){
        modalTitle.innerHTML = "Error";
        modalContent.innerHTML = "Las contraseñas no coinciden.";
        modal.show();
        return;
    }
    $.ajax({
        url: "api/updatePassword.php",
        type: "POST",
        data: {
            oldPassword: oldPassword,
            newPassword: newPassword
        },
        success: function(response) {
            $('#page-loader').fadeOut(500);
            if (response == '1'){
                modalTitle.innerHTML = "Contraseña Actualizada";
                modalContent.innerHTML = "La contraseña ha sido actualizada correctamente.";
                //clean fields
                $("#oldPassword").val("");
                $("#newPassword").val("");
                $("#confirmPassword").val("");
            }else{
                modalTitle.innerHTML = "Error";
                modalContent.innerHTML = response;
            }
            modal.show();
        }
    });
}

function selectFile(){
    $("#imageInput").click();
    $("#imageInput").off("change").change(function(){
        $('#page-loader').show();
        var image = $("#imageInput")[0].files[0];
        var formData = new FormData();
        formData.append("image", image);
        $.ajax({
            url: "api/uploadImage.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#page-loader').fadeOut(500);
                if (response == '1'){
                    window.location.href = "?option=0";
                }else{
                    modalTitle.innerHTML = "Error";
                    modalContent.innerHTML = response;
                }
                modal.show();
            }
        });
    });
};


/* ------------ADMINISTRAR USUARIOS-------------- */

function multiselectSave(form){
    formData = new FormData(form);
    userId = form.getAttribute("data-userId")
    selected = formData.getAll('select')
    
    data = {
        userId: userId,
        idFarmacias: selected
    }
    console.log(data)
    $.ajax({
        url: "api/updateUserFarmacias.php",
        type: "POST",
        data: data,
        success: function(response) {
            $('#page-loader').fadeOut(500);
            if (response == '1'){
                window.location.href = "?option=1";
            }else{
                modalTitle.innerHTML = "Error";
                modalContent.innerHTML = response;
            }
            modal.show();
        }
    });
}

function handleMultiselect(targetDetail){
    targetDetail.querySelector('form').reset();
    
    details = document.querySelectorAll('details')
    details.forEach(detail => {
        if (detail !== targetDetail) {
            detail.removeAttribute("open");
        }
    })
}

function newUser(){
    $('#page-loader').show();
    var username = $("#username").val();
    var password = $("#password").val();
    var email = $("#email").val();

    $.ajax({
        url: "api/newUser.php",
        type: "POST",
        data: {
            username: username,
            password: password,
            email: email
        },
        success: function(response) {
            $('#page-loader').fadeOut(500);
            if (response == '1'){
                window.location.href = "?option=1";
            }else{
                modalTitle.innerHTML = "Error";
                modalContent.innerHTML = response;
            }
            modal.show();
        }
    });
}

function changeDeleted(userId, deleted){
    $('#page-loader').show();
    $.ajax({
        url: "api/changeUserDeleted.php",
        type: "POST",
        data: {
            userId: userId,
            deleted: deleted
        },
        success: function(response) {
            $('#page-loader').fadeOut(500);
            if (response == '1'){
                window.location.href = "?option=1";
            }else{
                modalTitle.innerHTML = "Error";
                modalContent.innerHTML = response;
            }
            modal.show();
        }
    });
}