<form id="consulta-form" class="form" name="asis-form" action="./controllers/AsisFormController.php" method="POST">
    <h2 class="consulta">¿Necesitas asistencia?</h2>
    <div class="consulta">

        <label for="name" class="label">Nombre</label>
        <input required type="text" id="name" name="name_asis" class="form-input">
    </div>
    <div class="consulta">
        <label for="email" class="label">Email</label>
        <input required type="text" id="email" name="email_asis" class="form-input">

    </div>
    <div class="consulta">
        <label for="tele" class="label">Teléfono</label>
        <input required type="text" id="tele" name="tele_asis" class="form-input">
    </div>
    <div class="consulta">
        <label for="date" class="label">Fecha</label>
        <input required type="text" id="date" name="date_asis" class="form-input ">
    </div>
    <div class="consulta">
        <label for="message" class="label">Motivo de la consulta</label>
        <textarea required id="message" name="message_asis" class="form-textarea"></textarea>
    </div>
    <button type="submit" class="login-btn">Enviar Consulta</button>
</form>