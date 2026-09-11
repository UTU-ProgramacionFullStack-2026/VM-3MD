<?php
// Laboratorio didáctico: una cuenta por sesión, sin base de datos.
session_start();
header('Content-Type: text/html; charset=UTF-8');
header('Cache-Control: no-store');
$_SESSION['csrf'] ??= bin2hex(random_bytes(32));
function escapar(string $valor): string {
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
function campo(string $nombre): string {
    return isset($_POST[$nombre]) && is_string($_POST[$nombre]) ? $_POST[$nombre] : '';
}
$accion = campo('accion');
$mensaje = '';
$error = false;
$resultado = null;
$entrada = '';
$usuario = '';
$tab = 'login';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tab = $accion === 'registro' ? 'registro' : 'login';
    if (!hash_equals($_SESSION['csrf'], campo('csrf'))) {
        $mensaje = 'La sesión del formulario cambió. Volvé a intentarlo.';
        $error = true;
    } elseif ($accion === 'reiniciar') {
        unset($_SESSION['cuenta']);
        $mensaje = 'Laboratorio reiniciado. Ya podés crear otra cuenta.';
    } elseif (in_array($accion, ['registro', 'login'], true)) {
        $usuario = trim(campo('usuario'));
        $entrada = campo('password'); // No recortar: los espacios también son parte de la contraseña.
        if ($usuario === '' || strlen($usuario) > 80 || $entrada === '' || strlen($entrada) > 72 || str_contains($entrada, "\0")) {
            $mensaje = 'Completá el usuario (hasta 80 bytes) y una contraseña de entre 1 y 72 bytes, sin caracteres nulos.';
            $error = true;
        } elseif ($accion === 'registro') {
            // 1. Guardamos únicamente el hash, nunca la contraseña original.
            $hash = password_hash($entrada, PASSWORD_DEFAULT);
            $_SESSION['cuenta'] = ['usuario' => $usuario, 'hash' => $hash];
            session_regenerate_id(true);
            $mensaje = 'Cuenta de prueba creada. Ahora probá ingresar con esos mismos datos.';
        } elseif (!isset($_SESSION['cuenta'])) {
            $mensaje = 'Primero creá una cuenta en la pestaña de registro.';
            $error = true;
        } else {
            // 2. PHP compara la contraseña recibida con el hash guardado.
            $resultado = password_verify($entrada, $_SESSION['cuenta']['hash']);
            $acceso = $resultado && hash_equals($_SESSION['cuenta']['usuario'], $usuario);
            if ($acceso) session_regenerate_id(true);
            $mensaje = $acceso ? '¡Acceso correcto! Tu identidad fue verificada en esta demostración.' : 'Acceso denegado. El usuario o la contraseña no coinciden.';
            $error = !$acceso;
        }
    }
}
$cuenta = $_SESSION['cuenta'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docu · Laboratorio de acceso</title>
    <link rel="stylesheet" href="password.css">
</head>
<body>
<header class="topbar">
    <a class="brand" href="password.php"><span class="brand-icon" aria-hidden="true">d.</span> docu<span class="brand-divider">/</span><span class="brand-caption">Sistema de documentación</span></a>
    <span class="lab-badge"><span aria-hidden="true">●</span> Laboratorio PHP</span>
</header>
<main>
    <section class="intro">
        <p class="eyebrow">DOCUMENTOS ORGANIZADOS. ACCESOS SEGUROS.</p>
        <h1>Todo empieza con<br>una buena <span>contraseña.</span></h1>
        <p>Entrá a tu espacio de documentación y descubrí qué pasa<br class="desktop"> detrás de un login. Paso a paso, con PHP real.</p>
    </section>
    <div class="workspace">
        <section class="access-card" aria-labelledby="access-title">
            <div class="card-heading"><span class="tiny-icon" aria-hidden="true">↗</span><span> TU ESPACIO DE TRABAJO</span></div>
            <h2 id="access-title">Te damos la bienvenida</h2>
            <p class="muted">Una cuenta de prueba. Todo listo para aprender.</p>
            <div class="tabs" role="group" aria-label="Elegir formulario">
                <button type="button" data-tab="login" aria-pressed="<?= $tab === 'login' ? 'true' : 'false' ?>">Iniciar sesión</button>
                <button type="button" data-tab="registro" aria-pressed="<?= $tab === 'registro' ? 'true' : 'false' ?>">Crear cuenta</button>
            </div>
            <?php if ($mensaje): ?><div class="notice <?= $error ? 'error' : 'success' ?>" role="status"><?= escapar($mensaje) ?></div><?php endif; ?>
            <?php foreach (['login' => 'Ingresar al espacio', 'registro' => 'Crear cuenta de prueba'] as $tipo => $boton): ?>
            <form method="post" class="access-form" id="form-<?= $tipo ?>" <?= $tab !== $tipo ? 'hidden' : '' ?>>
                <input type="hidden" name="csrf" value="<?= escapar($_SESSION['csrf']) ?>">
                <input type="hidden" name="accion" value="<?= $tipo ?>">
                <label for="usuario-<?= $tipo ?>">Usuario</label>
                <input id="usuario-<?= $tipo ?>" name="usuario" placeholder="Ej.: maria.documentos" autocomplete="username" maxlength="80" value="<?= escapar($usuario ?: ($cuenta['usuario'] ?? '')) ?>" required>
                <label for="password-<?= $tipo ?>">Contraseña</label>
                <div class="password-field"><input id="password-<?= $tipo ?>" type="password" name="password" placeholder="Escribí tu contraseña de prueba" autocomplete="<?= $tipo === 'login' ? 'current-password' : 'new-password' ?>" maxlength="72" required><button type="button" class="reveal" data-target="password-<?= $tipo ?>" aria-pressed="false">Mostrar</button></div>
                <p class="field-help"><?= $tipo === 'login' ? 'Usá los datos que creaste en el registro.' : 'Esta demo admite hasta 72 bytes. Registrar reemplaza la cuenta de prueba anterior.' ?></p>
                <button class="primary" type="submit"><?= $boton ?><span aria-hidden="true">→</span></button>
            </form>
            <?php endforeach; ?>
            <div class="privacy-note"><span aria-hidden="true">ⓘ</span><p><strong>Este es un espacio para experimentar.</strong><br>Usá una contraseña inventada: acá podés revelar los datos para ver cómo funciona el proceso.</p></div>
        </section>
        <section class="lab-card" aria-labelledby="lab-title">
            <div class="lab-header"><div><p class="eyebrow">DETRÁS DEL LOGIN</p><h2 id="lab-title">La seguridad, a la vista.</h2></div><span class="live-badge">PHP EN VIVO</span></div>
            <p class="lab-description">Vos escribís una contraseña. PHP hace el resto.</p>
            <ol class="steps">
                <li><span class="step-number">01</span><div class="step-body"><h3>Lo que escribís <span>ENTRADA</span></h3><p>Los datos que enviaste en el último formulario.</p><div class="input-preview"><span>Usuario <strong><?= escapar($usuario ?: 'Esperando tu primer envío…') ?></strong></span><span>Contraseña <strong><?= $entrada !== '' ? '••••••••' : '—' ?></strong></span></div>
                <?php if ($entrada !== ''): ?><details><summary>Revelar contraseña enviada</summary><code class="revealed"><?= escapar($entrada) ?></code></details><?php endif; ?></div></li>
                <li><span class="step-number">02</span><div class="step-body"><h3>Lo que guardamos <span>HASH</span></h3><p>Al registrarte, transformamos tu contraseña en un hash.</p><pre><code><span class="code-variable">$hash</span> = <span class="code-function">password_hash</span>(
    $password, PASSWORD_DEFAULT
);</code></pre><div class="hash-output"><?= escapar($cuenta['hash'] ?? 'El hash aparecerá cuando crees una cuenta.') ?></div><p class="micro">La sesión guarda el usuario y el hash. La contraseña original no se guarda.</p></div></li>
                <li><span class="step-number">03</span><div class="step-body"><h3>Lo que comprobamos <span>VERIFICACIÓN</span></h3><p>Al ingresar, verificamos la contraseña contra el hash guardado.</p><pre><code><span class="code-variable">$coincide</span> = <span class="code-function">password_verify</span>(
    $password, $hash
);</code></pre><div class="result <?= $resultado === null ? '' : ($resultado ? 'valid' : 'invalid') ?>"><span class="result-dot" aria-hidden="true"></span><strong><?= $resultado === null ? 'Esperando un intento de acceso' : ($resultado ? 'true · La contraseña coincide' : 'false · La contraseña no coincide') ?></strong></div><p class="micro">Para permitir el acceso, también debe coincidir el usuario.</p></div></li>
            </ol>
        </section>
    </div>
    <section class="takeaways" aria-label="Conceptos clave"><article><span>01 / IRREVERSIBLE</span><h3>Un hash no se descifra.</h3><p>PHP verifica una coincidencia; no recupera la contraseña original.</p></article><article><span>02 / ÚNICO CADA VEZ</span><h3>Misma clave, distinto hash.</h3><p>Registrá la misma contraseña otra vez: la sal aleatoria cambia el resultado.</p></article><article><span>03 / APRENDER HACIENDO</span><h3>Equivocate a propósito.</h3><p>Probá ingresar con otra contraseña y observá cómo la verificación devuelve false.</p></article></section>
    <footer><span>docu / Un pequeño laboratorio de autenticación</span><form method="post"><input type="hidden" name="csrf" value="<?= escapar($_SESSION['csrf']) ?>"><button name="accion" value="reiniciar">↻ Reiniciar laboratorio</button></form><span>Cuenta temporal · Sin base de datos</span></footer>
</main>
<script>
document.querySelectorAll('[data-tab]').forEach(button => {
    button.addEventListener('click', () => {
        document.querySelectorAll('[data-tab]').forEach(tab => tab.setAttribute('aria-pressed', String(tab === button)));
        document.querySelectorAll('.access-form').forEach(form => form.hidden = form.id !== 'form-' + button.dataset.tab);
    });
});
document.querySelectorAll('.reveal').forEach(button => {
    button.addEventListener('click', () => {
        const input = document.getElementById(button.dataset.target);
        const visible = input.type === 'password';
        input.type = visible ? 'text' : 'password';
        button.textContent = visible ? 'Ocultar' : 'Mostrar';
        button.setAttribute('aria-pressed', String(visible));
    });
});
</script>
</body>
</html>
