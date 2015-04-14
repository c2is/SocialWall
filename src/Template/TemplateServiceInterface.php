<?php

namespace C2iS\SocialWall\Template;

use C2iS\SocialWall\Model\AbstractSocialItem;

interface TemplateServiceInterface
{
    /**
     * @param \C2iS\SocialWall\Model\AbstractSocialItem $socialItem
     *
     * @return string
     */
    public function render(AbstractSocialItem $socialItem);
}
