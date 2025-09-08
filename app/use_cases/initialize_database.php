    <?php

    require_once __DIR__ . '/../interface_adapters/gateway/database_initializer_repository.php';

    class InitializeDatabase
    {
        private $repository;

        public function __construct(DatabaseInitializerRepository $repository)
        {
            $this->repository = $repository;
        }

        public function execute($sqlFile = null)
        {
            $this->repository->createDatabaseIfNotExists();
            $this->repository->createTables();
            $imported = false;
            if ($sqlFile && file_exists($sqlFile)) {
                $this->repository->importSqlFile($sqlFile);
                $imported = true;
            }
            return [
                'tables_initialized' => true,
                'data_imported' => $imported,
                'sql_file' => $sqlFile
            ];
        }

        public function getRepository()
        {
            return $this->repository;
        }
    }