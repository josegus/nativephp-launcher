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
     */
    public function handle(string $input): array;

    /**
     * Ejecuta la acción al seleccionar una opción.
     */
    public function execute(array $data): void;
}
