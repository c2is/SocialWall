<?php /** @var \C2iS\SocialWall\Model\AbstractSocialItem $socialItem */ ?>
<div id="<?php echo sprintf('%s-%s', $socialItem->getSocialNetwork(), $socialItem->getId()); ?>" class="social-item">
    <?php if ($messageHtml = $socialItem->getMessageHtml()): ?>
        <p class="message"><?php echo $messageHtml; ?></p>
    <?php endif; ?>
    <?php if ($link = $socialItem->getLink()): ?>
        <a href="<?php echo $link; ?>" target="_blank"><?php echo $socialItem->getDatetime()->format('d/m/Y'); ?></a>
    <?php endif; ?>
</div>
