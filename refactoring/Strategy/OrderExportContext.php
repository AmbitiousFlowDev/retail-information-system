<?php

class OrderExportContext
{
    private ExportStrategy $strategy;

    public function setStrategy(ExportStrategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function export(array $data): void
    {
        $this->strategy->export($data);
    }
}
