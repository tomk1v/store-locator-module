<?php
/**
 * Store Locator
 * Controller process URL-request for delete more than one record
 *
 * @category  Internship
 * @package   Internship\StoreLocator
 * @author    Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2022 Elogic
 */

namespace Internship\StoreLocator\Controller\Adminhtml\Index;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;
use Internship\StoreLocator\Api\Data\LocationInterface;
use Internship\StoreLocator\Api\LocationRepositoryInterface;
use Internship\StoreLocator\Model\ResourceModel\Location\CollectionFactory;

class MassDelete extends Action
{
    /**
     * @var LocationRepositoryInterface
     */
    private $locationRepository;

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param LocationRepositoryInterface $locationRepository
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        LocationRepositoryInterface $locationRepository,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->locationRepository = $locationRepository;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return Redirect
     * @throws LocalizedException|Exception
     */
    public function execute()
    {
        /** @var AbstractCollection $collection */
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        if ($collectionSize > 0) {
            /** @var LocationInterface $item */
            foreach ($collection as $item) {
                $this->locationRepository->delete($item);
            }
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
