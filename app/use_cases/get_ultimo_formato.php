<?php
/*
Path: app/use_cases/get_ultimo_formato.php
*/


require_once __DIR__ . '/../interface_adapters/gateway/formato_repository_interface.php';
require_once __DIR__ . '/../entities/formato.php';

class GetUltimoFormato {
    protected $formatoRepository;
    public function __construct(FormatoRepositoryInterface $formatoRepository) {
        $this->formatoRepository = $formatoRepository;
    }
    public function execute() {
        $data = $this->formatoRepository->getUltimoFormato();
        // Mapear los datos a la entidad Formato
        return new Formato(
            $data['ID_formato'] ?? null,
            $data['formato'] ?? null,
            null, // fechaCreacion no disponible en la consulta actual
            $data
        );
    }
}
?>
