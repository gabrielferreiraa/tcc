<?php

namespace App\Lib;

use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

class Utils
{

    static function getIconFile($ext)
    {
        $iconExt = '';
        switch ($ext) {
            case 'txt':
                $iconExt = '<i class="fa fa-file-text-o"></i>';
                break;
            case 'pdf':
                $iconExt = '<i class="fa fa-file-pdf-o"></i>';
                break;
            case 'zip':
                $iconExt = '<i class="fa fa-file-zip-o"></i>';
                break;
            case 'jpg':
                $iconExt = '<i class="fa fa-file-picture-o"></i>';
                break;
            case 'jpeg':
                $iconExt = '<i class="fa fa-file-picture-o"></i>';
                break;
            case 'png':
                $iconExt = '<i class="fa fa-file-picture-o"></i>';
                break;
            case 'doc':
                $iconExt = '<i class="fa fa-file-word-o"></i>';
                break;
            case 'docx':
                $iconExt = '<i class="fa fa-file-word-o"></i>';
                break;
            case 'xls':
                $iconExt = '<i class="fa fa-file-excel-o"></i>';
                break;
            case 'xlsx':
                $iconExt = '<i class="fa fa-file-excel-o"></i>';
                break;
            case 'mp3':
                $iconExt = '<i class="fa fa-file-audio-o"></i>';
                break;
            case 'php':
                $iconExt = '<i class="fa fa-file-code-o"></i>';
                break;
            case 'js':
                $iconExt = '<i class="fa fa-file-code-o"></i>';
                break;
            case 'html':
                $iconExt = '<i class="fa fa-file-code-o"></i>';
                break;
            case 'css':
                $iconExt = '<i class="fa fa-file-code-o"></i>';
                break;
            case 'jar':
                $iconExt = '<i class="fa fa-file-code-o"></i>';
                break;
            case 'mp4':
                $iconExt = '<i class="fa fa-file-movie-o"></i>';
                break;
            case 'wav':
                $iconExt = '<i class="fa fa-file-movie-o"></i>';
                break;
            case 'avi':
                $iconExt = '<i class="fa fa-file-movie-o"></i>';
                break;
            case 'mpg':
                $iconExt = '<i class="fa fa-file-movie-o"></i>';
                break;
            case 'mpeg':
                $iconExt = '<i class="fa fa-file-movie-o"></i>';
                break;
            case 'ppt':
                $iconExt = '<i class="fa fa-file-powerpoint-o"></i>';
                break;
            case 'pptx':
                $iconExt = '<i class="fa fa-file-powerpoint-o"></i>';
                break;
        }

        if (empty($iconExt)) {
            $iconExt = '<i class="fa fa-file-archive-o"></i>';
        }

        return $iconExt;
    }

    static function r_acc($string)
    {
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');

        return str_replace($a, $b, trim($string));
    }

    function slugify($string)
    {
        $string = $this->r_acc($string);
        return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $string));
    }

    static function dateToBr($date, $time = false)
    {
        $date = Time::createFromFormat('Y-m-d', $date)->i18nFormat('dd/MM/YYYY');
        if ($time) {
            $date .= ' ' . $time;
        }
        return $date;
    }

    static function brToDate($date, $time = false)
    {
        $date = Time::createFromFormat('d/m/Y', $date)->i18nFormat('YYYY-MM-dd');
        if ($time) {
            $date .= ' ' . $time;
        }
        return $date;
    }

    static function getWeekday($day)
    {
        $days = [
            '1' => 'Domingo',
            '2' => 'Segunda-Feira',
            '3' => 'Terça-Feira',
            '4' => 'Quarta-Feira',
            '5' => 'Quinta-Feira',
            '6' => 'Sexta-Feira',
            '7' => 'Sábado'
        ];

        if (is_numeric($day)) {
            return $days[$day];
        }
    }

    static function getMonth($num, $type = 'full')
    {
        $months = [
            'full' => [
                1 => 'Janeiro',
                2 => 'Fevereiro',
                3 => 'Março',
                4 => 'Abril',
                5 => 'Maio',
                6 => 'Junho',
                7 => 'Julho',
                8 => 'Agosto',
                9 => 'Setembro',
                10 => 'Outubro',
                11 => 'Novembro',
                12 => 'Dezembro'
            ],
            'min' => [
                1 => 'Jan',
                2 => 'Fev',
                3 => 'Mar',
                4 => 'Abr',
                5 => 'Mai',
                6 => 'Jun',
                7 => 'Jul',
                8 => 'Ago',
                9 => 'Set',
                10 => 'Out',
                11 => 'Nov',
                12 => 'Dez'
            ]
        ];

        if (is_numeric($num)) {
            return $months[$type][$num];
        } else {
            return array_search($num, $months[$type]);
        }
    }

    static function getPeriod($type, $num)
    {
        $periodName = '';
        switch ($type) {
            case 1:
                $periodName = self::getMonth($num);
                break;
            case 2:
                $periodName = $num . 'º Bimestre';
                break;
            case 3:
                $periodName = $num . 'º Trimestre';
                break;
            case 4:
                $periodName = $num . 'º Quadrimestre';
                break;
            case 6:
                $periodName = $num . 'º Semestre';
                break;
        }
        return $periodName;
    }

    static function getPeriodByMonth($type, $month)
    {
        return $periodNum = ceil($month / $type);
    }

    static function getVideoId($url)
    {
        $youtubePattern = '/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"\'>]+)/';
        $vimeoPattern = '/(https?:\/\/)?(www.)?(player.)?vimeo.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/';
        $pattern = $youtubePattern;
        $patternIndex = 1;//index padrão youtube
        $type = 'youtube';
        $matches = [];

        //video do vimeo
        if (strpos($url, 'vimeo') !== false) {
            $pattern = $vimeoPattern;
            $patternIndex = 5;//index padrão vimeo
            $type = 'vimeo';
        }

        preg_match($pattern, $url, $matches);

        if (isset($matches[$patternIndex]))
            return ['type' => $type, 'id' => $matches[$patternIndex]];
        return false;
    }

    static function getEmbedPlayer($id, $type = 'youtube')
    {
        $urls = [
            'youtube' => "https://www.youtube.com/embed/{$id}?rel=0&showinfo=0&color=white&iv_load_policy=3",
            'vimeo' => "http://player.vimeo.com/video/{$id}?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff",
        ];

        $url = isset($urls[$type]) ? $urls[$type] : $urls['youtube'];

        $player = "<div class='embed-responsive embed-responsive-16by9'><iframe class='video_item' id='{$id}' type='text/html' src='{$url}' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>";
        return $player;
    }
}
