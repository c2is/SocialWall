<?php

namespace C2iS\SocialWall\Template;

use C2iS\SocialWall\Model\SocialItemInterface;

interface TemplateServiceInterface
{
    /**
     * @param \C2iS\SocialWall\Model\SocialItemInterface $socialItem
     *
     * @return string
     */
    public function render(SocialItemInterface $socialItem);
}
