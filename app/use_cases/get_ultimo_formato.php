<?php
/*
Path: app/use_cases/get_ultimo_formato.php
*/

require_once __DIR__ . '/../interface_adapters/gateway/formato_repository_interface.php';

class GetUltimoFormato {
    protected $formatoRepository;
    public function __construct(FormatoRepositoryInterface $formatoRepository) {
        $this->formatoRepository = $formatoRepository;
    }
    public function execute() {
        return $this->formatoRepository->getUltimoFormato();
    }
}
?>
