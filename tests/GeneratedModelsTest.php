<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Échoue si src/Model n'a pas été régénéré après une modification du swagger :
 * lancer `composer generate`.
 */
final class GeneratedModelsTest extends TestCase
{
    private const SWAGGER = __DIR__.'/../../../../api/docs/swagger.json';

    public function testLesModelesSontAJourDuSwagger(): void
    {
        if (!is_file(self::SWAGGER)) {
            self::markTestSkipped('Swagger introuvable hors du monorepo.');
        }

        $output = sys_get_temp_dir().'/api-client-models-'.bin2hex(random_bytes(4));
        exec(\sprintf('%s %s %s %s 2>&1', \PHP_BINARY, escapeshellarg(__DIR__.'/../bin/generate-models.php'), escapeshellarg(self::SWAGGER), escapeshellarg($output)), $lines, $code);
        self::assertSame(0, $code, implode("\n", $lines));

        try {
            $expected = $this->read($output);
            self::assertSame(array_keys($expected), array_keys($this->read(__DIR__.'/../src/Model')), 'La liste des modèles diffère du swagger.');
            foreach ($expected as $file => $content) {
                self::assertSame($content, file_get_contents(__DIR__.'/../src/Model/'.$file), "{$file} n'est pas à jour : lancer `composer generate`.");
            }
        } finally {
            array_map(unlink(...), glob($output.'/*.php') ?: []);
            rmdir($output);
        }
    }

    /**
     * @return array<string, string>
     */
    private function read(string $dir): array
    {
        $files = [];
        foreach (glob($dir.'/*.php') ?: [] as $path) {
            $files[basename($path)] = (string) file_get_contents($path);
        }
        ksort($files);

        return $files;
    }
}
