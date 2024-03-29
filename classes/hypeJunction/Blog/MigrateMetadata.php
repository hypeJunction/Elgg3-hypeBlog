<?php

namespace hypeJunction\Blog;

use Elgg\Database\QueryBuilder;
use Elgg\Upgrade\Batch;
use Elgg\Upgrade\Result;

class MigrateMetadata implements Batch {

	/**
	 * Version of the upgrade
	 *
	 * This tells the date when the upgrade was added. It consists of eight digits and is in format ``yyyymmddnn``
	 * where:
	 *
	 * - ``yyyy`` is the year
	 * - ``mm`` is the month (with leading zero)
	 * - ``dd`` is the day (with leading zero)
	 * - ``nn`` is an incrementing number (starting from ``00``) that is used in case two separate upgrades
	 *          have been added during the same day
	 *
	 * @return int E.g. 2016123101
	 */
	public function getVersion() {
		return 2018030800;
	}

	/**
	 * Should this upgrade be skipped?
	 *
	 * If true, the upgrade will not be performed and cannot be accessed later.
	 *
	 * @return bool
	 */
	public function shouldBeSkipped() {
		return !$this->countItems();
	}

	/**
	 * Should the run() method receive an offset representing all processed items?
	 *
	 * If true, run() will receive as $offset the number of items already processed. This is useful
	 * if you are only modifying data, and need to use the $offset in a function like elgg_get_entities*()
	 * to know how many to skip over.
	 *
	 * If false, run() will receive as $offset the total number of failures. This should be used if your
	 * process deletes or moves data out of the way of the process. E.g. if you delete 50 objects on each
	 * run(), you may still use the $offset to skip objects that already failed once.
	 *
	 * @return bool
	 */
	public function needsIncrementOffset() {
		return true;
	}

	/**
	 * The total number of items to process during the upgrade
	 *
	 * If unknown, Batch::UNKNOWN_COUNT should be returned, and run() must manually mark the result
	 * as complete.
	 *
	 * @return int
	 */
	public function countItems() {
		return elgg_get_entities([
			'types' => 'object',
			'subtypes' => 'blog',
			'wheres' => function(QueryBuilder $qb) {
				$alias = $qb->joinMetadataTable('e', 'guid', ['published_status', 'disable_comments'], 'left');

				return $qb->compare("$alias.value", "IS NULL");
			},
			'count' => true,
		]);
	}

	/**
	 * Runs upgrade on a single batch of items
	 *
	 * If countItems() returns Batch::UNKNOWN_COUNT, this method must call $result->markCompleted()
	 * when the upgrade is complete.
	 *
	 * @param Result $result Result of the batch (this must be returned)
	 * @param int    $offset Number to skip when processing
	 *
	 * @return Result Instance of \Elgg\Upgrade\Result
	 */
	public function run(Result $result, $offset) {
		$entities = elgg_get_entities([
			'types' => 'object',
			'subtypes' => 'blog',
			'wheres' => function(QueryBuilder $qb) {
				$alias = $qb->joinMetadataTable('e', 'guid', ['published_status', 'disable_comments'], 'left');

				return $qb->compare("$alias.value", "IS NULL");
			},
			'offset' => $offset,
		]);

		foreach ($entities as $entity) {
			/* @var $entity \hypeJunction\Blog\Download */

			if (!isset($entity->published_status)) {
				if ($entity->status == 'draft' || $entity->status == 'unsaved_draft') {
					$entity->published_status = H_DRAFT;
				} else if ($entity->status == 'published' || empty($entity->status)) {
					$entity->published_status = H_PUBLISHED;
				}
			}

			if (!isset($entity->disable_comments)) {
				if ($entity->comments_on == 'On') {
					$entity->disable_comments = false;
				} else {
					$entity->disable_comments = true;
				}
			}

			$result->addSuccesses();
		}

		return $result;
	}

}