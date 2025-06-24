<?php

namespace Yolotest\Offer\Ui\Component\Listing\Column;

use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class OfferActions extends Column
{

    protected $urlPathEdit = 'yolotest_offer/offer/edit';
    protected $urlPathDelete = 'yolotest_offer/offer/delete';
    protected $entityId = 'offer_id';
    protected $nameColumn = 'offer_id';

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param Escaper $escaper
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        protected readonly UrlInterface $urlBuilder,
        protected readonly Escaper $escaper,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item[$this->entityId])) {
                    $title = $this->escaper->escapeHtmlAttr($item[$this->nameColumn]);
                    $nameColum = __('Delete');
                    $message =  __('Are you sure you want to delete the record?');
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                $this->urlPathEdit,
                                [
                                    $this->entityId => $item[$this->entityId]
                                ]
                            ),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                $this->urlPathDelete,
                                [
                                    $this->entityId => $item[$this->entityId]
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                $this->nameColumn => $nameColum,
                                'message' => $message
                            ],
                            'post' => true
                        ],
                    ];
                }
            }
        }

        return $dataSource;
    }
}
