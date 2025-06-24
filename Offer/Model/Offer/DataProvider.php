<?php

namespace Yolotest\Offer\Model\Offer;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Yolotest\Offer\Model\ResourceModel\Offer\Collection;

class DataProvider extends ModifierPoolDataProvider
{

    private WriteInterface $mediaDirectory;
    protected array $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param Collection $collection
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        private readonly StoreManagerInterface $storeManager,
        $name,
        $primaryFieldName,
        $requestFieldName,
        Filesystem $filesystem,
        Collection $collection,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
        $this->collection = $collection;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $this->loadedData = [];
        $items = $this->collection->getItems();
        foreach ($items as $entity) {
            $data = $entity->getData();

            if (isset($data['image'])) {
                $image = $data['image'];
                $data['image'] = [];
                $data['image'][0] = [
                    'name' => $this->getFileName($image),
                    'url' => $this->getMediaUrl($image),
                    'size' => $this->getFileSize($image)
                ];
            }
            $this->loadedData[$entity->getId()] = $data;
        }

        return $this->loadedData;
    }

    /**
     * @param string $path
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getMediaUrl(string $path = ''): string
    {
        $mediaUrl = $this->storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $path;
        return $mediaUrl;
    }

    /**
     * @param string $file
     * @return int
     */
    public function getFileSize(string $file): int
    {
        $fileSize = 0;
        try {
            $fileSize = $this->mediaDirectory->stat($file)['size'];
        } catch (FileSystemException $e) {
        }
        return $fileSize;
    }

    /**
     * @param string $file
     * @return string
     */
    public function getFileName(string $file): string
    {
        $fileName = explode('/', $file);
        return end($fileName);
    }
}
