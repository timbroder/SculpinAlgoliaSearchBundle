<?php

namespace Timbroder\Bundle\AlgoliaBundle\Search;

use Sculpin\Core\Source\AbstractSource;

/**
 * Class AlgoliaDocumentBuilder
 * @author Tim Broder <timothy.broder@gmail.com>
 */
class AlgoliaDocumentBuilder implements DocumentBuilderInterface
{
    /**
     * {@inheritDoc}
     */
    public function build(AbstractSource $source)
    {
        $sourceId = $source->sourceId();

        $tags = (is_array($source->data()->get('tags'))) ? $source->data()->get('tags') : array();
        $categories = (is_array($source->data()->get('categories'))) ? $source->data()->get('categories') : null;

        $record = array(
            'objectID' => md5($sourceId),
            'title' => $source->data()->get('title'),
            'content' => strip_tags($source->content()),
            'link' => $source->permalink()->relativeUrlPath(),
            'date' => $source->data()->get('calculated_date')
        );

        // add em if we have em
        if ($categories != NULL) {
            $record["categories"] = $categories;
        }

        if ($tags != NULL) {
            $record["tags"] = $tags;
        }

        return $record;
    }
}