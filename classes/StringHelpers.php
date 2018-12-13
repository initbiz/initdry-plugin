<?php namespace Initbiz\InitDry\Classes;

/**
 * Class with string helpers
 */
class StringHelpers
{
    /**
     * Method by Scott Arciszewski: https://stackoverflow.com/a/31107425
     * Generate a random string, using a cryptographically secure
     * pseudorandom number generator (random_int)
     *
     * @param int    $length    How many characters do we want?
     * @param string $keyspace  A string of all possible characters to select from
     * @return string
     */
    public static function random_str(int $length, string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    /**
     * Upper case every word after delimiter
     * @param  string $string       string to upper case after all delimiters
     * @param  array  $delimiters   array of delimiters to uppercase after
     * @return string               parsed string
     */
    public static function ucwords(string $string, $delimiters = [' ', '-', '\'', '"', "."]): string
    {
        $string = mb_strtolower($string);

        foreach ($delimiters as $delimiter) {
            if (strpos($string, $delimiter) !== false) {
                $parts = explode($delimiter, $string);
                foreach ($parts as &$part) {
                    $part = self::mb_ucfirst($part);
                }
                $string = implode($delimiter, $parts);
            }
        }

        //First letter
        $string = self::mb_ucfirst($string);

        return $string;
    }

    /**
     * First letter uppercase in string
     * @param  string $string   string to make first letter upper case
     * @param  string $encoding encoding
     * @return string           First letter uppercased string
     */
    public static function mb_ucfirst(string $string, string $encoding = 'UTF-8')
    {
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }
}
