<?php

namespace Modelos;
use Clases\Database;
use PDO;

class Esqueleto {
    public private(set) int $idEsq;
    public private(set) string $especie;
    public private(set) string $periodo;
    public private(set) ?string $lugar;
    public private(set) ?string $descripcion;
    public private(set) string $estadoEsq;
    /**
     * @var string
    */
    public private(set) ?string $fechaEsq {
        get => date("d/m/Y", strtotime($this->fechaEsq) ) ;
    }
        
    /**
     * Method listarEsqueletos
     *
     * @return array
     */
    public static function listarEsqueletos() : array|false {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM Esqueleto;");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, Esqueleto::class);
    }
        
    /**
     * Method anadirEsqueleto
     *
     * @param array $datos 
     *
     * @return bool
     */
    public static function anadirEsqueleto(array $datos): bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("INSERT INTO Esqueleto (especie, periodo, lugar, descripcion, estadoEsq, fechaEsq) 
                               VALUES (:especie, :periodo, :lugar, :descripcion, :estadoEsq, :fechaEsq);");
        return $stmt->execute($datos);
    }
    
    /**
     * Method borrarEsqueletoPorId
     *
     * @param int $id 
     *
     * @return bool
     */
    public static function borrarEsqueletoPorId(int $id) : bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("DELETE FROM Esqueleto WHERE idEsq=:ide;");
        return $stmt->execute(["ide"=>$id]);
    }
    
    /**
     * Method getEsqueletoPorId
     *
     * @param int $id 
     *
     * @return Esqueleto
     */
    public static function getEsqueletoPorId(int $id) : Esqueleto|false {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM Esqueleto WHERE idEsq=:ide;");
        $stmt->execute(["ide"=>$id]);
        return $stmt->fetchObject(Esqueleto::class);
    }
    
    /**
     * Method editarEsqueletoPorId
     *
     * @param int $id 
     * @param array $datos
     *
     * @return bool
     */
    public static function editarEsqueletoPorId(int $id, array $datos) : bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("UPDATE Esqueleto 
                               SET especie=:especie, periodo=:periodo, lugar=:lugar, descripcion=:descripcion, estadoEsq=:estadoEsq, fechaEsq=:fechaEsq
                               WHERE idEsq=:idEsq;");
        return $stmt->execute([...$datos, ":idEsq"=>$id]);
    }
    
}