<?php
// app/helpers/entity_helper.php

function validateEntity($data, $type) {
    $errors = [];
    if ($type === 'estudiante') {
        if (empty($data['nombre'])) $errors['nombre'] = 'El nombre es obligatorio';
        if (empty($data['matricula'])) $errors['matricula'] = 'La matrícula es obligatoria';
        if (empty($data['universidad_id'])) $errors['universidad_id'] = 'La universidad es obligatoria';
    } elseif ($type === 'universidad') {
        if (empty($data['nombre'])) $errors['nombre'] = 'El nombre es obligatorio';
        if (empty($data['clave'])) $errors['clave'] = 'La clave es obligatoria';
    } elseif ($type === 'profesor') {
        if (empty($data['nombre'])) $errors['nombre'] = 'El nombre es obligatorio';
        if (empty($data['rfc'])) $errors['rfc'] = 'El RFC es obligatorio';
        if (empty($data['universidad_id'])) $errors['universidad_id'] = 'La universidad es obligatoria';
    }
    return $errors;
}

function createEntity($pdo, $data, $type) {
    try {
        if ($type === 'estudiante') {
            $stmt = $pdo->prepare("INSERT INTO estudiantes (nombre, matricula, universidad_id) VALUES (?, ?, ?)");
            return $stmt->execute([$data['nombre'], $data['matricula'], $data['universidad_id']]);
        } elseif ($type === 'universidad') {
            $stmt = $pdo->prepare("INSERT INTO universidades (nombre, clave) VALUES (?, ?)");
            return $stmt->execute([$data['nombre'], $data['clave']]);
        } elseif ($type === 'profesor') {
            $stmt = $pdo->prepare("INSERT INTO profesores (nombre, rfc, universidad_id) VALUES (?, ?, ?)");
            return $stmt->execute([$data['nombre'], $data['rfc'], $data['universidad_id']]);
        }
        return false;
    } catch (PDOException $e) {
        error_log("DB error createEntity($type): " . $e->getMessage());
        return false;
    }
}

function getEntities($pdo, $type) {
    try {
        if ($type === 'estudiante') {
            $stmt = $pdo->query("SELECT * FROM estudiantes");
        } elseif ($type === 'universidad') {
            $stmt = $pdo->query("SELECT * FROM universidades");
        } elseif ($type === 'profesor') {
            $stmt = $pdo->query("SELECT * FROM profesores");
        } else {
            return [];
        }
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    } catch (PDOException $e) {
        error_log("DB error in getEntities($type): " . $e->getMessage());
        return [];
    }
}

function getEntityById($pdo, $type, $id) {
    try {
    if ($type === 'estudiante') {
        $stmt = $pdo->prepare("SELECT * FROM estudiantes WHERE id = ?");
    } elseif ($type === 'universidad') {
        $stmt = $pdo->prepare("SELECT * FROM universidades WHERE id = ?");
    } elseif ($type === 'profesor') {
        $stmt = $pdo->prepare("SELECT * FROM profesores WHERE id = ?");
    }
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("DB error in getEntityById($type,$id): " . $e->getMessage());
        return null;
    }
}

function updateEntity($pdo, $data, $type, $id) {
    try {
        if ($type === 'estudiante') {
            $stmt = $pdo->prepare("UPDATE estudiantes SET nombre = ?, matricula = ?, universidad_id = ? WHERE id = ?");
            return $stmt->execute([$data['nombre'], $data['matricula'], $data['universidad_id'], $id]);
        } elseif ($type === 'universidad') {
            $stmt = $pdo->prepare("UPDATE universidades SET nombre = ?, clave = ? WHERE id = ?");
            return $stmt->execute([$data['nombre'], $data['clave'], $id]);
        } elseif ($type === 'profesor') {
            $stmt = $pdo->prepare("UPDATE profesores SET nombre = ?, rfc = ?, universidad_id = ? WHERE id = ?");
            return $stmt->execute([$data['nombre'], $data['rfc'], $data['universidad_id'], $id]);
        }
        return false;
    } catch (PDOException $e) {
        error_log("DB error updateEntity($type): " . $e->getMessage());
        return false;
    }
}

function deleteEntity($pdo, $type, $id) {
    try {
        if ($type === 'estudiante') {
            $stmt = $pdo->prepare("DELETE FROM estudiantes WHERE id = ?");
        } elseif ($type === 'universidad') {
            $stmt = $pdo->prepare("DELETE FROM universidades WHERE id = ?");
        } elseif ($type === 'profesor') {
            $stmt = $pdo->prepare("DELETE FROM profesores WHERE id = ?");
        } else {
            return false;
        }
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        error_log("DB error deleteEntity($type): " . $e->getMessage());
        return false;
    }
}
