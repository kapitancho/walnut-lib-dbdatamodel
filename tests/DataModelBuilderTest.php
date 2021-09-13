<?php

use PHPUnit\Framework\TestCase;
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
use Walnut\Lib\DbDataModel\DataModel;
use Walnut\Lib\DbDataModel\DataModelBuilder;
use Walnut\Lib\DbDataModel\DataPart;
use Walnut\Lib\DbDataModel\InvalidDataModel;

final class MockInvalidDataModel {}

#[ModelRoot('users')]
final class MockDataModel {

	#[Table("users")]
	#[Fields("first_name", "last_name")]
	#[KeyField("user_id")]
	#[ParentField("customer_id")]
	#[CrossTable("customer_users", 'customer_id', 'user_id', 'parent')]
	#[SortField("sequence")]
	#[GroupField("group_id")]
	#[OneOf("credentials", 'user_credentials')]
	#[ListOf("roles", 'user_roles')]
	public array $users;

}

final class DataModelBuilderTest extends TestCase {

	public function testOk(): void {
		$dataModelBuilder = new DataModelBuilder;
		$dataModel = $dataModelBuilder->build(MockDataModel::class);
		$this->assertNotNull($dataModel->part('users'));
	}

	public function testInvalidModelRoot(): void {
		$this->expectException(InvalidDataModel::class);
		$dataModelBuilder = new DataModelBuilder;
		$dataModelBuilder->build(MockInvalidDataModel::class);
	}

}