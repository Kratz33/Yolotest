<?php

namespace Yolotest\Offer\Block\Adminhtml\Offer\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton implements ButtonProviderInterface
{

    /**
     * @param Context $context
     */
    public function __construct(private readonly Context $context)
    {
    }

    /**
     * @return array
     */
    public function getButtonData(): array
    {
        $data = [];
        $data = [];
        if ($this->getId() && $this->isAllowed()) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => sprintf(
                    "deleteConfirm('%s', '%s')",
                    __('Are you sure you want to delete this offer?'),
                    $this->getDeleteUrl()
                ),
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * Get the ID from the request
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return (int) $this->context->getRequest()->getParam('offer_id');
    }

    /**
     * Get URL for delete button
     *
     * @return string
     */
    public function getDeleteUrl(): string
    {
        return $this->context->getUrlBuilder()->getUrl('*/*/delete', ['offer_id' => $this->getId()]);
    }

    /**
     * Check if the user has permission to delete
     *
     * @return bool
     */
    private function isAllowed(): bool
    {
        return $this->context->getAuthorization()->isAllowed('Yolotest_Offer::offer_delete');
    }
}
