<?php
/**
 * Store Locator
 * Ui Component for displaying drop down menu in admin
 *
 * @category  Internship
 * @package   Internship\StoreLocator
 * @author    Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2022 Elogic
 */

namespace Internship\StoreLocator\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Internship\StoreLocator\Api\Data\LocationInterface;

class LocationActions extends Column
{
    /** Url path */
    const PATH_EDIT   = 'locations/index/edit';
    const PATH_DELETE = 'locations/index/delete';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item[LocationInterface::KEY_ID])) {
                    $item[$name]['edit'] = [
                        'href'  => $this->urlBuilder->getUrl(
                            self::PATH_EDIT, ['id' => $item[LocationInterface::KEY_ID]]
                        ),
                        'label' => __('Edit'),
                    ];
                    $item[$name]['delete'] = [
                        'href'    => $this->urlBuilder->getUrl(
                            self::PATH_DELETE,
                            ['id' => $item[LocationInterface::KEY_ID]]
                        ),
                        'label'   => __('Delete'),
                        'confirm' => [
                            'title'   => __('Delete') . ' ' . $item[LocationInterface::KEY_NAME],
                            'message' => __(
                                'Are you sure you wan\'t to delete a record?'
                            ),
                        ],
                    ];
                }
            }
        }
        return $dataSource;
    }
}
