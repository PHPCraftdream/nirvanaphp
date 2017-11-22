<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {
	interface PageDataInterface extends ListDataInterface {
		public function jsonSerialize();

		public function getOffset(): int;

		public function setOffset(int $value): PageDataInterface;

		public function getPageSize(): int;

		public function setPageSize(int $value): PageDataInterface;

		public function getPage(): int;

		public function setPage(int $value): PageDataInterface;

		public function getCount(): int;

		public function setCount(int $value): PageDataInterface;

		public function getPagesCount(): int;

		public function setPagesCount(int $value): PageDataInterface;

		public function fillCountInfo(int $page, int $count, int $pageSize): PageDataInterface;
	}
}