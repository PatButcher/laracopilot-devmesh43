<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ValidateFileUpload
{
    /**
     * Allowed MIME types mapped to their file extensions.
     */
    private array $allowedAudioMimes = [
        'audio/mpeg'  => ['mp3'],
        'audio/wav'   => ['wav'],
        'audio/wave'  => ['wav'],
        'audio/x-wav' => ['wav'],
        'audio/ogg'   => ['ogg'],
        'audio/flac'  => ['flac'],
        'audio/x-flac'=> ['flac'],
        'audio/aac'   => ['aac'],
        'audio/mp4'   => ['m4a', 'mp4'],
    ];

    private array $allowedImageMimes = [
        'image/jpeg' => ['jpg', 'jpeg'],
        'image/png'  => ['png'],
        'image/webp' => ['webp'],
        'image/gif'  => ['gif'],
    ];

    private int $maxAudioBytes = 52428800;  // 50 MB
    private int $maxImageBytes = 5242880;   // 5 MB

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasFile('audio_file')) {
            $result = $this->validateFile(
                $request->file('audio_file'),
                $this->allowedAudioMimes,
                $this->maxAudioBytes,
                'audio'
            );
            if ($result !== null) {
                return $request->expectsJson()
                    ? response()->json(['error' => $result], 422)
                    : back()->withErrors(['audio_file' => $result])->withInput();
            }
        }

        foreach (['cover_image', 'image', 'avatar'] as $field) {
            if ($request->hasFile($field)) {
                $result = $this->validateFile(
                    $request->file($field),
                    $this->allowedImageMimes,
                    $this->maxImageBytes,
                    'image'
                );
                if ($result !== null) {
                    return $request->expectsJson()
                        ? response()->json(['error' => $result], 422)
                        : back()->withErrors([$field => $result])->withInput();
                }
            }
        }

        return $next($request);
    }

    private function validateFile($file, array $allowedMimes, int $maxBytes, string $type): ?string
    {
        if (!$file->isValid()) {
            Log::warning('Invalid file upload attempted', ['error' => $file->getErrorMessage()]);
            return 'File upload failed or was corrupted.';
        }

        // Check file size
        if ($file->getSize() > $maxBytes) {
            return 'File exceeds maximum allowed size of ' . round($maxBytes / 1048576) . 'MB.';
        }

        // Validate MIME type via finfo (reads actual file bytes, not just extension)
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $realMime = $finfo->file($file->getRealPath());

        if (!array_key_exists($realMime, $allowedMimes)) {
            Log::warning('Disallowed file MIME type upload', [
                'declared_mime' => $file->getMimeType(),
                'real_mime'     => $realMime,
                'original_name' => $file->getClientOriginalName(),
            ]);
            return 'Invalid ' . $type . ' file type. Detected: ' . $realMime;
        }

        // Validate extension matches actual MIME
        $ext = strtolower($file->getClientOriginalExtension());
        if (!in_array($ext, $allowedMimes[$realMime], true)) {
            Log::warning('File extension mismatch', [
                'extension' => $ext,
                'real_mime' => $realMime,
            ]);
            return 'File extension does not match file content.';
        }

        // Check for PHP code injection in image files (image shell injection)
        if ($type === 'image') {
            $content = file_get_contents($file->getRealPath(), false, null, 0, 512);
            if (preg_match('/<\?php|<\?=/i', $content)) {
                Log::critical('PHP injection attempt in image upload', [
                    'ip'   => request()->ip(),
                    'file' => $file->getClientOriginalName(),
                ]);
                return 'File contains invalid content.';
            }
        }

        return null;
    }
}