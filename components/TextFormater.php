<?php

namespace app\components;

use yii\helpers\Url;

class TextFormater
{
    /**
     * @param string $content
     * @return string
     */
    public static function toHtml($content)
    {
        $content = preg_replace('|\*\*\[([\w\s]*)\]\*\*|', '<b>${1}</b>', $content);
        $content = preg_replace('|\\\\\\\\\[([\w\s]*)\]\\\\\\\\|', '<i>${1}</i>', $content);
        $content = preg_replace_callback('|\(\(([\w\/]+) \[([\w\s]+)\]\)\)|',
            function ($matches) {
                $url = Url::to(['pages/show', 'path' => $matches[1]], true);
                return '<a href="'.$url.'">'.$matches[2].'</a>';
            },
            $content
        );

        return nl2br($content);
    }
}