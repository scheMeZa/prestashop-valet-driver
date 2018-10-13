<?php

class PrestaShopValetDriver extends ValetDriver
{
    /**
     * Determine if the driver serves the request.
     *
     * @param  string $sitePath
     * @param  string $siteName
     * @param  string $uri
     *
     * @return bool
     */
    public function serves($sitePath, $siteName, $uri)
    {
        return file_exists($sitePath . '/classes/PrestaShopAutoload.php');
    }

    /**
     * Determine if the incoming request is for a static file.
     *
     * @param  string $sitePath
     * @param  string $siteName
     * @param  string $uri
     *
     * @return string|false
     */
    public function isStaticFile($sitePath, $siteName, $uri)
    {
        // Basic static file
        if (is_file($staticFilePath = "{$sitePath}/{$uri}")) {
            return $staticFilePath;
        }

        return false;
    }

    /**
     * Get the fully resolved path to the application's front controller.
     *
     * @param  string $sitePath
     * @param  string $siteName
     * @param  string $uri
     *
     * @return string
     */
    public function frontControllerPath($sitePath, $siteName, $uri)
    {
        if (preg_match('/(.*)modules(.*)/', $uri)) {
            return $sitePath . $uri;
        }

        if (preg_match('/(.*)admin(.*)/', $uri)) {
            $adminDirectoryName = explode(DIRECTORY_SEPARATOR, $uri)[1];
            $sitePath           .= DIRECTORY_SEPARATOR . $adminDirectoryName;
        }

        return $sitePath . '/index.php';
    }
}
