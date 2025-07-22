<?php

namespace NativePHPLauncher\Core;

interface Plugin
{
    /**
     * Nombre del comando o activador del plugin (ej: "google", "open").
     */
    public function keyword(): string;

    /**
     * Devuelve los resultados que el usuario puede ver al escribir.
     *
     * @return array<int, \NativePHPLauncher\Core\Contracts\Items\ResultItem>
     */
    public function handle(string $input): array;

    /**
     * Ejecuta la acción al seleccionar una opción.
     */
    public function execute(array $data): void;
}
