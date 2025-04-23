<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OllamaService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('ollama.url', 'http://127.0.0.1:11434'); // Asegúrate de que la URL esté configurada correctamente
    }

    /**
     * Analiza la imagen con el modelo de Ollama.
     *
     * @param string $imagePath Ruta completa de la imagen.
     * @param array $prompts Prompts a enviar al modelo.
     * @return array Respuestas de Ollama.
     */
    public function analyzeImage(string $imagePath, array $prompts): array
    {
        $responses = [];

        // Convertir la imagen a base64
        $base64Image = base64_encode(file_get_contents($imagePath));

        foreach ($prompts as $prompt) {
            // Enviar la solicitud a Ollama
            $response = Http::timeout(60)->post("http://host.docker.internal:11434/api/generate", [
                'model' => 'minicpm-v',
                'prompt' => $prompt,
                'images' => [$base64Image],
                'stream' => false
            ]);

            if ($response->successful()) {
                // Guardar la respuesta de Ollama
                $responses[] = $response->json();
            } else {
                // En lugar de usar Log, solo se lanza el error para manejarlo en el controlador
                throw new \Exception("Error al procesar la imagen con Ollama");
            }
        }

        return $responses;
    }

    /**
     * Analiza la respuesta de Ollama y determina si la imagen contiene un animal y/o contenido sensible.
     *
     * @param array $responses Respuestas obtenidas de Ollama.
     * @return array Información procesada con los resultados de análisis.
     */
    public function analyzeResponse(array $responses): array
    {
        $result = [
            'contenidoSensible' => false,
            'contieneAnimal' => false,
            'descripcion' => ''
        ];

        // Comprobación de respuestas para contenido sensible y animales
        if (isset($responses[0]['response'])) {
            $contenidoSensible = strtolower(trim($responses[0]['response'])) === 'sí';
            $result['contenidoSensible'] = $contenidoSensible;
        }

        if (isset($responses[1]['response'])) {
            $contieneAnimal = strtolower(trim($responses[1]['response'])) === 'sí';
            $result['contieneAnimal'] = $contieneAnimal;
        }

        // Guardamos la descripción general si la respuesta está disponible
        if (isset($responses[0]['response'])) {
            $result['descripcion'] = $responses[0]['response'];
        }

        return $result;
    }
}


