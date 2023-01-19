<?php

namespace Appsas;

use Appsas\Exceptions\MissingVariableException;
use Appsas\Exceptions\PageNotFoundException;
use Appsas\Exceptions\UnauthenticatedException;
use Exception;
use Monolog\Logger;

class ExceptionHandler
{
    public function __construct(private Output $output, private Logger $log)
    {
    }

    public function handle(Exception $e)
    {
        match (get_class($e)) {
            PageNotFoundException::class => $this->handlePageNotFoundException($e),
            UnauthenticatedException::class => $this->handleUnauthenticatedException($e),
            MissingVariableException::class => $this->handleMissingVariableException($e),
            \PDOException::class => $this->handlePDOException($e),
            default => $this->handleDefaultException($e),
        };
    }

    private function handleDefaultException(Exception $e): void
    {
        $this->output->store('Oi nutiko klaida! Bandyk vėliau dar karta.');
        $this->log->error($e->getMessage());
    }

    private function handlePageNotFoundException(PageNotFoundException $e): void
    {
        $this->log->warning($e->getMessage());
        header('Location: /?message=Page not found');

    }

    private function handleUnauthenticatedException(UnauthenticatedException $e): void
    {
        $this->log->notice($e->getMessage());
        header('Location: /?message=Neteisingi prisijungimo duomenys');
    }

    private function handleMissingVariableException(MissingVariableException $e): void
    {
        $this->output->store('Kilo klaida templeite.');
        $this->log->notice($e->getMessage());
    }

    private function handlePDOException(\PDOException $e)
    {
        $this->output->store('Kilo klaida duombazeje.');
        $this->log->error($e->getMessage());
    }
}