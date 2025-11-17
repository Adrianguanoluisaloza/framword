<?php
// validation_helper.php
// Funciones simples para validar formularios de la app

function validate_persona(array $data, PDO $db, array $options = []) {
    $errors = [];
    $rolesPermitidos = $options['roles'] ?? ['estudiante', 'profesor', 'universidad'];

    // Nombres
    if (empty($data['nombres'])) {
        $errors['nombres'] = 'El campo nombres es obligatorio.';
    } elseif (mb_strlen($data['nombres']) < 2) {
        $errors['nombres'] = 'Los nombres deben tener al menos 2 caracteres.';
    }

    // Apellidos
    if (empty($data['apellidos'])) {
        $errors['apellidos'] = 'El campo apellidos es obligatorio.';
    } elseif (mb_strlen($data['apellidos']) < 2) {
        $errors['apellidos'] = 'Los apellidos deben tener al menos 2 caracteres.';
    }

    // Fecha de nacimiento (opcional)
    if (!empty($data['fechanacimiento'])) {
        $d = DateTime::createFromFormat('Y-m-d', $data['fechanacimiento']);
        if (!$d || $d->format('Y-m-d') !== $data['fechanacimiento']) {
            $errors['fechanacimiento'] = 'La fecha de nacimiento tiene un formato inválido (YYYY-MM-DD).';
        }
    }

    // Rol
    $rol = $data['rol'] ?? '';
    if (empty($rol) || !in_array($rol, $rolesPermitidos, true)) {
        $errors['rol'] = 'Debes seleccionar un rol válido.';
    }

    // Sexo: verificar que el id exista en tabla sexo
    if (empty($data['idsexo'])) {
        $errors['idsexo'] = 'Debes seleccionar un sexo.';
    } else {
        $stmt = $db->prepare('SELECT COUNT(*) AS cnt FROM sexo WHERE id = ?');
        $stmt->execute([$data['idsexo']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row || (int)$row['cnt'] === 0) {
            $errors['idsexo'] = 'El sexo seleccionado no es válido.';
        }
    }

    // Estado civil
    if (empty($data['idestadocivil'])) {
        $errors['idestadocivil'] = 'Debes seleccionar un estado civil.';
    } else {
        $stmt = $db->prepare('SELECT COUNT(*) AS cnt FROM estadocivil WHERE idestadocivil = ?');
        $stmt->execute([$data['idestadocivil']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row || (int)$row['cnt'] === 0) {
            $errors['idestadocivil'] = 'El estado civil seleccionado no es válido.';
        }
    }

    // Detalle opcional
    if (!empty($data['detalle']) && mb_strlen($data['detalle']) > 500) {
        $errors['detalle'] = 'El detalle no puede exceder 500 caracteres.';
    }

    return $errors;
}

?>
