<?php
/**
 * The Random Random Number Source
 *
 * This uses the *nix /dev/random device to generate high strength numbers
 *
 * PHP version 5.3
 *
 * @category   PHPCryptLib
 * @package    Random
 * @subpackage Source
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 * @copyright  2011 The Authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    Build @@version@@
 */

namespace CryptLib\Random\Source;

use CryptLib\Core\Strength\High as HighStrength;

/**
 * The Random Random Number Source
 *
 * This uses the *nix /dev/random device to generate high strength numbers
 *
 * @category   PHPCryptLib
 * @package    Random
 * @subpackage Source
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 * @codeCoverageIgnore
 */
class Random implements \CryptLib\Random\Source {

    /**
     * Return an instance of Strength indicating the strength of the source
     *
     * @return Strength An instance of one of the strength classes
     */
    public static function getStrength() {
        return new HighStrength();
    }

    /**
     * Generate a random string of the specified size
     *
     * @param int $size The size of the requested random string
     *
     * @return string A string of the requested size
     */
    public function generate($size) {
        if ($size == 0) {
            return '';
        }
        if (!file_exists('/dev/random')) {
            return str_repeat(chr(0), $size);
        }
        $file = fopen('/dev/random', 'rb');
        if (!$file) {
            return str_repeat(chr(0), $size);
        }
        stream_set_read_buffer($file, 0);
        $result = fread($file, $size);
        fclose($file);
        return str_pad($result, $size, chr(0));
    }

}
