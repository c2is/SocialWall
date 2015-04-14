<?php

namespace C2iS\SocialWall\Template;

use C2iS\SocialWall\Model\AbstractSocialItem;

class TemplateService implements TemplateServiceInterface
{
    /**
     * @param \C2iS\SocialWall\Model\AbstractSocialItem $socialItem
     *
     * @return string
     */
    public function render(AbstractSocialItem $socialItem)
    {
        if (!file_exists($file = sprintf('%s/views/%s.html.php', __DIR__, $socialItem->getSocialNetwork()))) {
            $file = sprintf('%s/views/%s.html.php', __DIR__, 'social_item');
        }

        ob_start();
        require $file;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

}
