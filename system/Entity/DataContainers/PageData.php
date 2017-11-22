<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {

	class PageData extends ListData implements PageDataInterface {
		protected $pageData = [
			'offset' => 10,
			'pageSize' => 10,
			'page' => 1,
			'count' => 0,
			'pagesCount' => 0,
		];

		public function jsonSerialize() {
			return $this->pageData + $this->jsonSerializeListData();
		}

		public function getOffset(): int {
			return $this->pageData['offset'];
		}

		public function setOffset(int $value): PageDataInterface {
			$this->pageData['offset'] = $value;

			return $this;
		}

		public function getPageSize(): int {
			return $this->pageData['pageSize'];
		}

		public function setPageSize(int $value): PageDataInterface {
			$this->pageData['pageSize'] = $value;

			return $this;
		}

		public function getPage(): int {
			return $this->pageData['page'];
		}

		public function setPage(int $value): PageDataInterface {
			$this->pageData['page'] = $value;

			return $this;
		}

		public function getCount(): int {
			return $this->pageData['count'];
		}

		public function setCount(int $value): PageDataInterface {
			$this->pageData['count'] = $value;

			return $this;
		}

		public function getPagesCount(): int {
			return $this->pageData['pagesCount'];
		}

		public function setPagesCount(int $value): PageDataInterface {
			$this->pageData['pagesCount'] = $value;

			return $this;
		}

		public function fillCountInfo(int $page, int $count, int $pageSize): PageDataInterface {
			$this->setPage($page);
			$this->setPageSize($pageSize);
			$this->setCount($count >= 1 ? $count : 0);

			$pagesCount = $pageSize > 0 ? ceil($count / $pageSize) : 1;
			if ($pagesCount < 1) $pagesCount = 1;
			$this->setPagesCount($pagesCount);

			$offset = ($page > 0) && ($count > 0) ? ($page - 1) * $pageSize : 0;
			$this->setOffset($offset);

			return $this;
		}
	}
}