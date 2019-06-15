<?php
declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CzechNbspExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('nbsp', [$this, 'insertNbsp']),
        ];
    }

    const NBSP = ' ';

    public static function insertNbsp($text)
    {
        #jednoznakové předložky a spojky
        #a ta hromada znaků je unicode representace diakrittiky á-ž...
        #unicode diakritika by Grudl \xe1\xe4\xe8\xef\xe9\xec\xed\xbe\xe5\xf2\xf3\xf6\xf5\xf4\xf8\xe0\x9a\x9d\xfa\xf9\xfc\xfb\xfd\x9e\xc1\xc4\xc8\xcf\xc9\xcc\xcd\xbc\xc5\xd2\xd3\xd6\xd5\xd4\xd8\xc0\x8a\x8d\xda\xd9\xdc\xdb\xdd\x8e
        $text = preg_replace(
                        '/([\s| ]){1}([aksvzouiKSVZOUIA]{1})([\s]{1})([0-9a-zA-ZáäčďéěíľĺňóöőôřŕšťúůüűýžÁÄČĎÉĚÍĽĹŇÓÖŐÔŘŔŠŤÚŮÜŰÝŽ]{1})/u',
                        '$1$2'.self::NBSP.'$4',
                        $text);
        #více znakové předložky
        $text = preg_replace(
                        '/([\s| ]){1}(od|do|bez|krom|kromě|místo|podle|kolem|podél|okolo|vedle|během|pomocí|stran|prostřednictvím|proti|naproti|kvůli|díky|pro|za|před|mimo|na|pod|pode|nad|nade|mezi|krom|kromě|skrz|skrze|po|při)([\s]){1}([<|0-9a-zA-ZáäčďéěíľĺňóöőôřŕšťúůüűýžÁÄČĎÉĚÍĽĹŇÓÖŐÔŘŔŠŤÚŮÜŰÝŽ]{1})/u',
                        '$1$2'.self::NBSP.'$4',
                        $text);
        #čísla s mezerou jako 1 000 0000
        $text = preg_replace(
                        '/([\d])([ ])([\d])/',
                        '$1'.self::NBSP.'$3',
                        $text);
        #datum včetně samotného data mezi tagy např. <b>1. 2. 2010</b>
        $text = preg_replace(
                        '/([>| ])([\d]{1,2}[\.]{1})([ ]){1}([\d]{1,2}[\.])([ ]){1}([\d]{4})([ |<])/',
                        '$1$2'.self::NBSP.'$4'.self::NBSP.'$6$7',
                        $text);
        #měrné jednotky co jsem kde našel
        $text = preg_replace(
                        '/([\d]){1}([ ]){1}(%|m|kg|s|A|K|mol|cd|rad|sr|m2|m3|m&sup1;|m&sup3;|Hz|N|J|W|Pa|UA|pc|px|pt|h|min|d|°C|°F|&ordm;|C|&ordm;C|eV|b|VA|D|l|var|ly|em|ex|C|U|F|Ω|&Omega;|Wb|H|T|lm|lux|Bq|Gy|Sv|dB|DU|bit|B|kB|MB|GB|TB|KiB|MiB|TiB|GiB|PiB|EiB|ZiB|YiB|NiB|DiB|kbit|Mbit|Gbit|Kibit|Mibit|Gibit|kb|Mb|Gb|Kib|Mib|Gib|kbps|Mbps|Gbps|Kibps|Mibps|Gibps)([ |,|\.|;|<])/',
                        '$1'.self::NBSP.'$3$4',
                        $text);
        #základní měny
        $text = preg_replace(
                        '/([\d|-]){1}([\s]){1}(&euro;|Euro|EUR|CZK|Kč){1}/u',
                        '$1'.self::NBSP.'$3',
                        $text);
        #prefixové znaky
        $text = preg_replace(
            '/(§){1}([\s]){1}(\d){1}/u',
            '$1'.self::NBSP.'$3',
            $text);
        return trim($text);
    }
}