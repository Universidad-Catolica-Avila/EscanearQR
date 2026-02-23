<?php
    use Mgj\ProyectoBlog2025\Config\Parameters;
?>

<main class="main-content">
    <header class="content-header" style="margin-bottom: 20px;">
        <h2 class="title-primary">Gestión de Usuarios</h2>
        <p class="subtitle">Listado oficial de usuarios registrados en el sistema académico.</p>
    </header>

    <section class="user-list">
        <?php
            $users = $data["users"] ?? NULL;

            if ($users && count($users) > 0) {
                
                foreach ($users as $user) {
                    $nombre = $user->Nombre ?? $user->nombre ?? 'Sin nombre';
                    $apellidos = $user->Apellidos ?? $user->apellidos ?? 'Sin apellidos';
                    $email = $user->Email ?? $user->email ?? 'Sin email';
                    $rol = $user->Rol ?? $user->rol ?? 'user';
                    $id = $user->ID ?? $user->id ?? '';

                    echo "<article class='post-card' style='margin-bottom: 20px; border-left: 5px solid #004a99; padding: 15px; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);'>";
                        echo "<div style='display: flex; justify-content: space-between; align-items: center;'>";
                            echo "<div>";
                                echo "<strong>Nombre completo:</strong> " . $nombre . " " . $apellidos . "<br>";
                                echo "<strong>Email:</strong> " . $email . "<br>";
                                echo "<strong>Rol actual:</strong> <span class='badge' style='text-transform: uppercase; font-weight: bold;'>" . $rol . "</span>";
                            echo "</div>";
                            
                            echo "<div>";
                                echo "<a href='".Parameters::$BASE_URL."Usuario/showEditar&id=".$id."' class='boton boton-verde' style='padding: 5px 10px; text-decoration: none; font-size: 0.8em; margin-right: 5px;'>Editar</a>";
                                echo "<a href='".Parameters::$BASE_URL."Usuario/showEliminar&id=".$id."' class='boton boton-rojo' style='padding: 5px 10px; text-decoration: none; font-size: 0.8em;'>Eliminar</a>";
                            echo "</div>";
                        echo "</div>";
                    echo "</article>";
                }

            } else {
                echo "<div class='alert alert-error'><h3>No existen usuarios registrados en la base de datos</h3></div>";
            }
        ?>
    </section>
</main>