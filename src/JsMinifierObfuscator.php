<?php
namespace Andrusdev\JsMinifierObfuscator;

use Composer\Script\Event;
use JShrink\Minifier;

/**
 * Andrusdev Js Minifier and Obfuscator
 * 
 * @author: Andrés J. Pavón Fernández <ajavier900710@gmail.com>
 */
class JsMinifierObfuscator
{
    public static function minifyAndObfuscate(Event $event) {
        $composer   = $event->getComposer();
        $extra      = $composer->getPackage()->getExtra();

        $event->getIO()->write('Minify and Obfuscate: Initiating library');
        
        $file_paths = $extra['js-minifier-obfuscator'] ?? [];

        foreach ($file_paths as $file_path) {
            if (file_exists($file_path)) {
                $event->getIO()->write(sprintf('Minify and Obfuscate: Processing the file %s', $file_path));
                $file_js_content = file_get_contents($file_path);

                // Minify
                $file_js_content = Minifier::minify($file_js_content, ['flaggedComments' => false]);

                // Obfuscate
                /* $hunter = new HunterObfuscator($file_js_content);
                $file_js_content = $hunter->Obfuscate(); */

                file_put_contents($file_path, $file_js_content);
                $event->getIO()->write(sprintf('Minify and Obfuscate: End for file %s', $file_path));
            } else {
                $event->getIO()->write(sprintf('Minify and Obfuscate: Not found the file %s', $file_path));
            }
        }

        $event->getIO()->write('Minify and Obfuscate: THE END');
    }
}
