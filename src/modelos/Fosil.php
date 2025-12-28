<?php
namespace Modelos;
use Clases\Database;
use PDO;

class Fosil {
    public private(set) int $idFos;
    private int $idEsq;
    public private(set) string $parte;
    public private(set) string $estadoFos;
    /**
     * @var string
     */
    public private(set) string $fechaFos {
        get => date("d/m/Y", strtotime($this->fechaFos) ) ;
    }

        
    /**
     * Method mostrarFosilesPorId
     *
     * @param int $id
     *
     * @return array
     */
    public static function mostrarFosilesPorId(int $id) : array {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM Fosil WHERE idEsq=:idf;");
        $stmt->execute([":idf" => $id]);
        
        return $stmt->fetchAll(PDO::FETCH_CLASS, Fosil::class);
    }

    public static function anadirFosil(array $datos): bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("INSERT INTO Fosil (parte, fechaFos, estadoFos, idEsq) 
                               VALUES (:parte, :fechaFos, :estadoFos, :idEsq);");
        return $stmt->execute($datos);
    }
    
    public static function borrarEsqueletoPorId(int $id) : bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("DELETE FROM Fosil WHERE idFos=:idf;");
        return $stmt->execute(["idf"=>$id]);
    }

    public static function getFosilPorId(int $id) : Fosil|false {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM Fosil WHERE idFos=:idf;");
        $stmt->execute(["idf"=>$id]);
        return $stmt->fetchObject(Fosil::class);
    }
    
    public static function editarFosilPorId(int $idFos, array $datos) : bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("UPDATE Fosil 
                               SET parte=:parte, idEsq=:idEsq, estadoFos=:estadoFos, fechaFos=:fechaFos
                               WHERE idFos=:idFos;");
        return $stmt->execute([...$datos, ":idFos"=>$idFos, ":idEsq"=>Fosil::getFosilPorId($idFos)->idEsq]);
    }
}
        