<?php
    require __DIR__ . "/../controladores/ControladorAdmin.php";
    $controlador = new ControladorAdmin();
    $variables = $controlador->usuario();
    $usuario = $variables["usuario"];
    $carrera = $variables["carrera"];
    $universidad = $variables["universidad"];
ob_start(); ?>
<div class="col-9" id="principal">
    <div class="fila profile">
        <!--Div para el fondo del perfil-->
        <div id="fondo"><img src="../img/usuarios/portada/<?php echo $usuario->imagenportada ?>"/></div>
        <!--Div para el avatar del perfil-->
        <div id="avatar"><img src="../img/usuarios/perfil/<?php echo $usuario->avatar ?>"/></div>
        <ul id="actividad">
            <li id="actividad-1">
                <span><?php echo count($usuario->alias('alice')->ownContactoList) + count($usuario->alias('bob')->ownContactoList) ?> </span>
                <small>Amigos</small>
            </li>
            <li id="actividad-2">
                <span><?php echo count($variables["apuntes"]) ?> </span>
                <small>Apuntes</small>
            </li>
        </ul>
    </div>
    <div class="description">
        <h2 class="col-9"><?php echo $usuario->nombre . " " . $usuario->apellidos ?></h2>
        <div class="clear"></div>
        <hr>
        <blockquote>
            <p> 
               <?php echo $usuario->estado ?>
            </p>
        </blockquote>
    </div><br>
    <div>
        <div class="clear"></div>
        <section>
            <h2><i class="fa fa-info-circle"></i> Info</h2>
            <div>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Nombre completo:</strong> <?php echo $usuario->nombre . " " . $usuario->apellidos ?></li>
                    <li class="list-group-item"><strong>Universidad:</strong> <?php echo $universidad->nombre ?></li>
                    <li class="list-group-item"><strong>Carrera:</strong> <?php echo $carrera->nombre ?> </li>
                </ul>
            </div>
        </section>

        <section>
            <div>
                <p>
                    <a href="usuarios-detalles.php?id=<?php echo $usuario->id ?>" class="boton boton-activo">Apuntes</a>
                    <a href="usuarios-detalles-grupos.php?id=<?php echo $usuario->id ?>" class="boton">Grupos</a>
                    <a href="usuarios-detalles-amigos.php?id=<?php echo $usuario->id ?>" class="boton">Amigos</a>
                </p>
            </div>
            
            <?php foreach($variables["amigos"] as $amigo):
                $apuntes = R::findAll("apunte", "usuario_id = ?", [$amigo->id]);
            ?>
                <div class="fila">
                    <p>
                        <span class="col-6">
                            <img class="col-1" src="../img/usuarios/perfil/<?php echo $amigo->avatar ?>" class="img-responsive mini-logo">
                            <strong><a href="usuarios-detalles.php?id=<?php echo $amigo->id ?>"> <?php echo $amigo->nombre?></a></strong>
                        </span>
                        <span class="col-4">
                            <?php
                            $carreraAmigo = R::findOne("carrera", "id = " . $amigo->carrera_id);
                            $universidadAmigo = R::findOne("universidad", "id = " . $carreraAmigo->universidad_id);
                            ?>
                            <a href="perfil-universidad.php?id=<?php echo $universidadAmigo->id ?>"> <?php echo $universidadAmigo->nombre ?></a>
                        </span>
                        <span class="col-2"><span class="fa fa-file"></span> <?php echo count($apuntes) ?> </span>
                    </p>
                    <div class="clear"></div>
                </div>
            <?php endforeach; ?>         
    
    </div>
    <div class="fila">
        <h3>Opciones de administrador:</h3>

        <h4>Enviar mensaje al usuario:</h4>
        <form action="usuarios-detalles.php" method="post">
            <textarea class="campo-formulario"></textarea>
            <input type="submit" class="campo-formulario" value="Enviar mensaje">
        </form>
        <p>
            
           <a href="../servicios/adminHandler.php?action=borrarUsuario&idUsuario=<?php echo $usuario->id ?>" class="boton campo-formulario">Eliminar usuario</a>
         
        </p>
    </div>
</div>
<div class="col-3">
    <p>
        <img src="../img/line-graph.gif" class="img-responsive">
        <img src="../img/line-graph.gif" class="img-responsive">
        <img src="../img/line-graph.gif" class="img-responsive">
    </p>
</div>

<?php
$contenido = ob_get_clean();
require "../common/admin/layout.php";
