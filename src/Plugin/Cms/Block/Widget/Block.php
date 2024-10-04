<?php

declare(strict_types=1);

namespace Infrangible\CmsBlockMetaData\Plugin\Cms\Block\Widget;

use FeWeDev\Base\Variables;
use Infrangible\Core\Helper\Cms;
use Magento\Framework\View\Page\Config;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Block
{
    /** @var Cms */
    protected $cmsHelper;

    /** @var Config */
    protected $pageConfig;

    /** @var Variables */
    protected $variables;

    public function __construct(Cms $cmsHelper, Config $pageConfig, Variables $variables)
    {
        $this->cmsHelper = $cmsHelper;
        $this->pageConfig = $pageConfig;
        $this->variables = $variables;
    }

    public function afterSetData(\Magento\Cms\Block\Widget\Block $subject, $result, $key)
    {
        if ($key === 'block_id') {
            $cmsBlock = $this->getCmsBlock($subject);

            if ($cmsBlock && $cmsBlock->getId()) {
                $metaTitle = $cmsBlock->getData('meta_title');
                if ($metaTitle) {
                    $this->pageConfig->getTitle()->set($metaTitle);
                }

                $metaKeywords = $cmsBlock->getData('meta_keywords');
                if ($metaKeywords) {
                    $this->pageConfig->setKeywords($metaKeywords);
                }

                $metaDescription = $cmsBlock->getData('meta_description');
                if ($metaDescription) {
                    $this->pageConfig->setDescription($metaDescription);
                }
            }
        }

        return $result;
    }

    private function getCmsBlock(\Magento\Cms\Block\Widget\Block $block): ?\Magento\Cms\Model\Block
    {
        $blockId = $block->getData('block_id');

        try {
            return $blockId ? $this->cmsHelper->loadCmsBlock($this->variables->intValue($blockId)) : null;
        } catch (\Exception $exception) {
            return null;
        }
    }
}
