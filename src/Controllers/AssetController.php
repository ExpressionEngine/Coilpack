<?php

namespace Expressionengine\Coilpack\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AssetController
{
    public function __invoke()
    {
        $url = parse_url(URL::current());
        $disk = Storage::disk('coilpack');
        $caching = false;
        $file = implode(DIRECTORY_SEPARATOR, Request::segments());

        if ($disk->missing($file)) {
            abort(404);
        }
        // Handle app resources with caching
        if (preg_match('/\.(?:png|jpg|jpeg|gif|xml|js|json|css|eot|svg|otf|ttf|woff|woff2|scss|less|txt|ico)$/', $url['path'])) {
            $fileName = $disk->path($file);
            $lastModified = $disk->lastModified($file);
            $etagFile = File::hash($fileName);
            $ifModifiedSince = (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
            $etagHeader = (isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);

            // Set caching header
            $headers = [
                'Last-Modified' => gmdate('D, d M Y H:i:s', $lastModified).' GMT',
                'Etag' => $etagFile,
                'Cache-Control' => 'public',
            ];

            $mime_type = $disk->mimeType($file);
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);

            switch ($extension) {
                case 'css':
                    $mime_type = 'text/css';
                    break;
                case 'js':
                    $mime_type = 'application/javascript';
                    break;
                default:
                    break;
            }

            // Serve requested resource
            $headers['Content-Type'] = $mime_type;
            $headers['Content-Length'] = $disk->size($file);

            // Check if the requested resource has changed
            if ($caching && (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $lastModified || $etagHeader == $etagFile)) {
                // File has not changed - 304 Not Modified
                return response(null, 304, $headers);
            } else {
                return $this->fileResponse($file, $headers);
            }
        }
        // return $this->fileResponse($file);
        return $disk->get($file);
    }

    private function fileResponse($path, $headers)
    {
        $response = new StreamedResponse;
        $filename = $name ?? basename($path);
        $response->headers->replace($headers);

        $response->setCallback(function () use ($path) {
            $stream = Storage::disk('coilpack')->readStream($path);
            fpassthru($stream);
            fclose($stream);
        });

        return $response;
    }
}
