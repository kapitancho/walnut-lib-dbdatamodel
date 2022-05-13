<?php

namespace Walnut\Lib\DbDataModel;

use Walnut\Lib\DbDataModel\Attribute\CrossTable;
use Walnut\Lib\DbDataModel\Attribute\Fields;
use Walnut\Lib\DbDataModel\Attribute\GroupField;
use Walnut\Lib\DbDataModel\Attribute\KeyField;
use Walnut\Lib\DbDataModel\Attribute\ListOf;
use Walnut\Lib\DbDataModel\Attribute\OneOf;
use Walnut\Lib\DbDataModel\Attribute\ParentField;
use Walnut\Lib\DbDataModel\Attribute\SortField;
use Walnut\Lib\DbDataModel\Attribute\Table;

/**
 * @package Walnut\Lib\Persistence\Orm
 */
final class DataPart {
	/**
	 * Data constructor.
	 * @param Table $table
	 * @param Fields $fields
	 * @param KeyField $keyField
	 * @param ParentField|null $parentField
	 * @param CrossTable|null $crossTable
	 * @param SortField|null $sortField
	 * @param GroupField|null $groupField
	 * @param OneOf[] $oneOfFields
	 * @param ListOf[] $listOfFields
	 */
	public function __construct(
		public readonly Table $table,
		public readonly Fields $fields,
		public readonly KeyField $keyField,
		public readonly ?ParentField $parentField,
		public readonly ?CrossTable $crossTable,
		public readonly ?SortField $sortField,
		public readonly ?GroupField $groupField,
		public readonly array $oneOfFields,
		public readonly array $listOfFields
	) {}
}