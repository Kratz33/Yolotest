<?php

namespace Yolotest\Offer\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class CategoryOptions implements OptionSourceInterface
{

    /**
     * @param CollectionFactory $categoryCollectionFactory
     */
    public function __construct(private readonly CollectionFactory $categoryCollectionFactory)
    {
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function toOptionArray(): array
    {
        $options = [];
        $categories = $this->categoryCollectionFactory->create()
            ->addAttributeToSelect('name')
            ->addAttributeToFilter('is_active', 1);

        foreach ($categories as $category) {
            $indentation = str_repeat('--', $category->getLevel());
            $options[] = [
                'value' => $category->getId(),
                'label' => $indentation . ' ' . $category->getName(),
            ];
        }

        return $options;
    }
}
