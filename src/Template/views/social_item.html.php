<?php /** @var \C2iS\SocialWall\Model\AbstractSocialItem $socialItem */ ?>
<div id="<?php echo sprintf('%s-%s', $socialItem->getSocialNetwork(), $socialItem->getId()); ?>"
     class="<?php echo $socialItem->getSocialNetwork() ?> social-item">
    <?php if ($messageHtml = $socialItem->getMessageHtml()): ?>
        <p class="message"><?php echo $messageHtml; ?></p>
    <?php endif; ?>
    <?php if ($link = $socialItem->getLink()): ?>
    <a href="<?php echo $link; ?>" target="_blank">
        <?php endif; ?>
        <?php if ($image = $socialItem->getImage()): ?>
            <img <?php if ($title = $socialItem->getTitle()): ?>title="<?php echo $title; ?>"
                 <?php endif; ?>src="<?php echo $socialItem->getImage(); ?>"/>
        <?php endif; ?>
        <?php if ($link): ?>
    </a>
<?php endif; ?>
</div>
