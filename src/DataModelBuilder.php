<?php

namespace Walnut\Lib\DbDataModel;

use ReflectionClass;
use ReflectionProperty;
use ReflectionAttribute;
use ReflectionException;
use Walnut\Lib\DbDataModel\Attribute\CrossTable;
use Walnut\Lib\DbDataModel\Attribute\Fields;
use Walnut\Lib\DbDataModel\Attribute\GroupField;
use Walnut\Lib\DbDataModel\Attribute\KeyField;
use Walnut\Lib\DbDataModel\Attribute\ListOf;
use Walnut\Lib\DbDataModel\Attribute\ModelRoot;
use Walnut\Lib\DbDataModel\Attribute\OneOf;
use Walnut\Lib\DbDataModel\Attribute\ParentField;
use Walnut\Lib\DbDataModel\Attribute\SortField;
use Walnut\Lib\DbDataModel\Attribute\Table;

/**
 * @package Walnut\Lib\Persistence\Orm
 */
final class DataModelBuilder {

	/**
	 * @template T of object
	 * @param ReflectionClass|ReflectionProperty $r
	 * @param class-string<T> $className
	 * @return ?T
	 */
	private function getAttribute(
		ReflectionClass|ReflectionProperty $r,
		string $className
	) {
		/**
		 * @var ?T
		 */
		return ($r->getAttributes($className)[0] ?? null)?->newInstance();
	}

	/**
	 * @template T
	 * @param ReflectionClass|ReflectionProperty $r
	 * @param class-string<T> $className
	 * @return array<T>
	 */
	private function getAttributes(ReflectionClass|ReflectionProperty $r, string $className): array {
		return array_map(static fn(ReflectionAttribute $reflectionAttribute) =>
			$reflectionAttribute->newInstance(), $r->getAttributes($className));
	}

	/**
	 * @param class-string $modelClass
	 * @return DataModel
	 * @throws InvalidDataModel
	 */
	public function build(string $modelClass): DataModel {
		try {
			$r = new ReflectionClass($modelClass);
			$modelRoot = $this->getAttribute($r, ModelRoot::class) ??
				throw new InvalidDataModel("The model root is missing");

			$dataParts = [];
			foreach($r->getProperties() as $rp) {
				$dataParts[$rp->getName()] = new DataPart(
					$this->getAttribute($rp, Table::class) ??
						throw new InvalidDataModel("The table is missing"),
					$this->getAttribute($rp, Fields::class) ??
						throw new InvalidDataModel("The fields are missing"),
					$this->getAttribute($rp, KeyField::class) ??
						throw new InvalidDataModel("The key field is missing"),
					$this->getAttribute($rp, ParentField::class),
					$this->getAttribute($rp, CrossTable::class),
					$this->getAttribute($rp, SortField::class),
					$this->getAttribute($rp, GroupField::class),
					$this->getAttributes($rp, OneOf::class),
					$this->getAttributes($rp, ListOf::class),
				);
			}

			return new DataModel($modelRoot, $dataParts);
		} catch (ReflectionException $ex) {
			// @codeCoverageIgnoreStart
			throw new InvalidDataModel("Unexpected reflection problem:" . $ex);
			// @codeCoverageIgnoreEnd
		}
	}
}