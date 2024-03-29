<?php
/**
 * Store Locator
 * API Search Criteria which allows build your own queries
 *
 * @category  Internship
 * @package   Internship\StoreLocator
 * @author    Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2022 Elogic
 */

namespace Internship\StoreLocator\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface LocationSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return LocationInterface[]
     */
    public function getItems();

    /**
     * @param LocationInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
