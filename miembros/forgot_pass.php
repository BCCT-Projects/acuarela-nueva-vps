<?php  $classBody = "login"; include 'includes/header.php';  ?>
    <main>
        <form action="/s/recoverpassPortal/" method="POST" id="recoverpass" autocomplete="off">
            <h1>¿Olvidaste tu contraseña?</h1>
            <span>
                <label for="">
                Ingresar tu E-mail
                </label>
                <input type="email" placeholder="name@mail.com" name="email" id="email">
            </span>
            <button type="submit">Enviar</button>
            <a href="" class="link">Volver</a>
        </form>
    </main>
    <footer></footer>
</body>
<script src="js/jquery.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/additional-methods.min.js"></script>
<script src="js/jquery.form.js"></script>
<script src="js/main.js?v=<?=time()?>"></script>
<script src="../js/googleAnalytics.js?v=<?=time();?>"></script>

</html>